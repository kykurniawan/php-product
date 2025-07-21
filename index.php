<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar bg-body-tertiary border-bottom">
        <div class="container">
            <a class="navbar-brand" href="./index.php">PHP Products</a>
        </div>
    </nav>
    <main>
        <section>
            <div class="container py-5">
                <div class="card">
                    <div class="card-header">
                        Add Product
                    </div>
                    <div class="card-body">
                        <form id="form" method="post">
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="product" name="product">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity in Stock</label>
                                        <input type="number" min="0" class="form-control" id="quantity" name="quantity">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price per Item</label>
                                        <input type="number" min="0" class="form-control" id="price" name="price">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-4">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        Products
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="products">
                            <thead>
                                <tr>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Quantity in Stock</th>
                                    <th scope="col">Price per Item</th>
                                    <th scope="col">Datetime Submitted</th>
                                    <th scope="col">Total Value</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>