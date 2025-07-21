<?php

class ProductRepository
{
    private $products = [];

    public function __construct()
    {
        $this->products = json_decode(file_get_contents('db.json'), true) ?? [];
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function addProduct($product, $quantity, $price)
    {
        $this->products[] = [
            'id' => uniqid(),
            'product' => $product,
            'quantity' => (int)$quantity,
            'price' => (float)$price,
            'total' => (float)($quantity * $price),
            'submitted' => date('Y-m-d H:i:s'),
        ];

        file_put_contents('db.json', json_encode($this->products));
    }

    public function getProduct($id)
    {
        foreach ($this->products as $product) {
            if ($product['id'] == $id) {
                return $product;
            }
        }

        return null;
    }

    public function updateProduct($id, $product, $quantity, $price)
    {
        $productSaved = $this->getProduct($id);

        $productSaved['product'] = $product;
        $productSaved['quantity'] = (int)$quantity;
        $productSaved['price'] = (float)$price;
        $productSaved['total'] = (float)($quantity * $price);

        $products = array_map(function ($product) use ($productSaved) {
            if ($product['id'] == $productSaved['id']) {
                return $productSaved;
            }
            return $product;
        }, $this->products);

        $this->products = $products;

        file_put_contents('db.json', json_encode($this->products));
    }

    public function deleteProduct($id)
    {
        $this->products = array_filter($this->products, function ($product) use ($id) {
            return $product['id'] != $id;
        });

        file_put_contents('db.json', json_encode($this->products));
    }
}

// Handle the request
$method = $_SERVER['REQUEST_METHOD'];

$products = new ProductRepository();

if ($method == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    if ($id == '') {
        $ordered = $products->getProducts();
        usort($ordered, function ($a, $b) {
            return strtotime($b['submitted']) <=> strtotime($a['submitted']);
        });
        echo json_encode($ordered);
        exit;
    }

    $product = $products->getProduct($id);

    if ($product == null) {
        http_response_code(404);
        exit;
    }

    echo json_encode($product);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $product = $data['product'] ?? null;
    $quantity = $data['quantity'] ?? null;
    $price = $data['price'] ?? null;

    $products->addProduct($product, $quantity, $price);

    http_response_code(201);
    exit;
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $product = $data['product'] ?? null;
    $quantity = $data['quantity'] ?? null;
    $price = $data['price'] ?? null;


    $products->updateProduct($id, $product, $quantity, $price);

    http_response_code(200);
    exit;
}

if ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;

    if ($id === null) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing ID']);
        exit;
    }

    $products->deleteProduct($id);

    http_response_code(200);
    exit;
}
