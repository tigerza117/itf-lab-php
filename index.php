<html>

<head>
    <title>ITF Lab</title>
    <?php
$conn = mysqli_init();
mysqli_real_connect($conn, '63070092-db.mysql.database.azure.com', 'tigerza117@63070092-db', '0880880880Za', 'itflab', 3306);
if (mysqli_connect_errno($conn)) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$res = mysqli_query($conn, 'SELECT * FROM guestbook');
?>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>


<style>
</style>

<body class="bg-light">
    <div class="container bg-white mx-auto mt-3 rounded shadow-lg mb-3">
        <form id="insert" class="p-4">
            <div class="d-flex mb-2">
                <div class="w-50 mr-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="idLink">
                        Name
                    </label>
                    <input type="text" name="name" id="idName" placeholder="Enter Name" class="form-control">
                </div>
                <div class="w-50 ml-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="idLink">
                        Link
                    </label>
                    <input type="text" name="link" id="idLink" placeholder="Enter Link" class="form-control">
                </div>
            </div>
            <div class="mb-2">
                <label class="block w-100 text-gray-700 text-sm font-bold mb-2" for="idLink">
                    Comment
                </label>
                <textarea rows="5" cols="10" name="comment" id="idComment" placeholder="Enter Comment"
                    class="form-control"></textarea>
            </div>

            <button class="w-100 btn btn-primary" type="submit" id="commentBtn">Add Comment</button>
        </form>
    </div>
    <div class="container bg-white mx-auto rounded-lg shadow mt-3 p-4 mb-3">
        <p class="text-center">Comment DataTable.</p>
        <table id="table_id" class="border table">
            <thead class="thead-dark">
                <tr>
                    <th width="50">
                        <div align="center">#</div>
                    </th>
                    <th width="100">
                        <div align="left">Name</div>
                    </th>
                    <th width="350">
                        <div align="left">Comment</div>
                    </th>
                    <th width="150">
                        <div align="left">Link</div>
                    </th>
                    <th width="150">
                        <div align="center">Action</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($Result = mysqli_fetch_array($res)) {?>
                <tr id="<?php echo $Result['ID']; ?>">
                    <td align="center"><?php echo $Result['ID']; ?></td>
                    <td><?php echo $Result['Name']; ?></td>
                    <td><?php echo $Result['Comment']; ?></td>
                    <td><?php echo $Result['Link']; ?></td>
                    <td align="center"><button class="btn btn-primary"
                            onclick='Edit(<?php echo json_encode(['name' => $Result['Name'], 'comment' => $Result['Comment'], 'link' => $Result['Link']]); ?>)'>Edit</button>
                        <button class="btn btn-danger" onclick="Delete(<?php echo $Result['ID']; ?>)">Del</button>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
    <?php mysqli_close($conn);?>
</body>

<script>
function toggleButton(e) {
    e.attr("disabled") ? e.removeAttr("disabled") : e.attr("disabled", !0)
}

function Edit(data) {
    console.log(data)
    Swal.fire({
        title: 'Multiple inputs',
        html: '<input id="swal-input1" class="swal2-input">' +
            '<input id="swal-input2" class="swal2-input">' +
            '<input id="swal-input3" class="swal2-input">',
        focusConfirm: true,
        allowOutsideClick: false,
        preConfirm: () => {
            return [
                document.getElementById('swal-input1').value,
                document.getElementById('swal-input2').value,
                document.getElementById('swal-input3').value
            ]
        }
    });
}

function Delete(id) {
    console.log(id)
    $.ajax({
        url: "delete.php",
        method: 'post',
        data: {
            id: id
        },
        dataType: "json"
    }).done(({
        code
    }) => {
        if (code == 200) {
            $("#" + id).remove();
        }
    });
}

$(document).ready(function() {
    $('#table_id').DataTable();
    $('#insert').submit((e) => {
        e.preventDefault();
        var t = $(e.currentTarget),
            n = t.find("button");
        toggleButton(n);
        $.ajax({
            url: "insert.php",
            method: 'post',
            data: t.serializeArray(),
            dataType: "json"
        }).done(({
            code
        }) => {
            if (code == 200) {
                location.reload();
            }
        }).then(() => {
            toggleButton(n);
        });
    })
});
</script>

</html>
