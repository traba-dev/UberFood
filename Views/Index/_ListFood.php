
<div id="listFood" class="container">
    <div class="row">
        <div class="col-lg-6">
            <span>Create new food</span>
            <button type="button" id="btnNewFood" class="btn btn-md btn-primary">New Food</button>
        </div>
    </div>
  <div class="row">
    <div class="col-sm">
        <table id="foods" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
  </div>
</div>

<div id="formFood" class="container">
    <div class="row">
        <div class="col-sm">
            <form>
                <div class="form-group">
                    <label> Name: </label>
                    <input type="text" id="name" class="form-control" placeholder="Name of food">
                </div>
                <div class="form-group">
                    <label> Description: </label>
                    <input type="text" id="description" class="form-control" placeholder="Description">
                </div>
                <div class="form-group">
                    <label> Price: </label>
                    <input type="text" id="price" class="form-control" placeholder="Price">
                </div>
                <div class="form-group">
                    <label> Status: </label>
                    <select class="form-control" id="status" name="Status">
                        <option value="A">Active</option>
                        <option value="I">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label> Category: </label>
                    <select class="form-control" id="categoryID" name="Status">
                        <option value="1">Hamburguesa</option>
                        <option value="2">Hot Dog</option>
                        <option value="3">Nachos</option>
                        <option value="4">Platanos</option>
                        <option value="5">Papas Fritas</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" id="btnSave" class="btn btn-md btn-primary">Save</button>
                    <button type="button" id="btnCancel" class="btn btn-md btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function () {

            if(Cookies.get('user') == '' || Cookies.get('user') == ''){
                location.href = 'Login.php';
            }

            function validateFields(field,mensaje){
            if (field.val() == '') {
                bootbox.alert(mensaje);
                return false;
                }
                return true;
            }

            function loadTable(){
                //Load Data in table
                var table = $('#foods').DataTable({
                    ajax: {
                        method: 'GET',
                        url: 'https://agrocontrolcr.com/agroTest/index.php/foods',
                        dataSrc: ''
                    },
                    columns: [
                        {
                            data: 'name'
                        },
                        {
                            data: 'description'
                        },
                        {
                            data: 'price'
                        },
                        {
                            data: 'status',
                            render: function (data, type, food) {
                                return (food.status == 'I') ? 'Inactive' : 'Active';
                            }
                        }
                        ,
                        {
                            data: 'catname'
                        },
                        {
                            data: 'id',
                            render: function (data) {
                                return '<button class="btn-link js-delete" data-food-id="' + data + '">Delete</button>';
                            }
                        }
                    ]
                });
            }
            
            loadTable();
            

            

            $('#foods').on('click', '.js-delete', function () {
                var button = $(this);

                bootbox.confirm('Are sure delete this food?', function (result) {
                    if (result) {
                        $.ajax({
                        url: 'https://agrocontrolcr.com/agroTest/index.php/deleteFood/'+button.attr('data-food-id'),
                        method: 'GET',
                        success: function () {
                            $('#foods').DataTable().row(button.parents("tr")).remove().draw();
                        }
                    });
                    }
                });
            });

            $('#btnNewFood').on('click',function(){
                $('#listFood').hide();
                $('#formFood').show();
            });
            $('#btnCancel').on('click',function(){
                $('#formFood').hide();
                $('#listFood').show();
            });
            $('#btnLogout').on('click',function(){
                location.href = 'Login.php';
            });
            $('#btnSave').on('click',function(){

                var name = $('#name');
                var description = $('#description');
                var price = $('#price');
                var status = $('#status');
                var categoryID = $('#categoryID');

                if(!validateFields(name,'The name is required')) return;
                if(!validateFields(description,'The description is required')) return;
                if(!validateFields(price,'The price is required')) return;
                if(!validateFields(status,'The status is required')) return;
                if(!validateFields(categoryID,'The categoryID is required')) return;
               

                $.ajax({
                    "url": "https://agrocontrolcr.com/agroTest/index.php/addFood",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    "data": {
                        "id": "0",
                        "name": name.val(),
                        "description": description.val(),
                        "price": price.val(),
                        "img": "test.jpg",
                        "status": status.val(),
                        "categoryID": categoryID.val()
                    },
                    statusCode: {
                        200: function(msg) {
                            bootbox.alert('Registro Guardado exitosamente');
                            $('#formFood').hide();
                            $('#listFood').show();
                            $('#foods').DataTable().clear().destroy();
                            loadTable();
                        },
                        500: function(msg){
                            bootbox.alert('Error was ocurred');
                            console.log(msg);
                        }
                    }
                    });
                });
        });
    </script>