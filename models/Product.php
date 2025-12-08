<?php
// models/Product.php
require_once 'Database.php';

class Product
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function getFeaturedProducts($limit)
    {
        $limit = (int)$limit; // Đảm bảo là số nguyên
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT); // Ràng buộc kiểu số nguyên
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecommendedProducts($limit)
    {
        $limit = (int)$limit; // Đảm bảo là số nguyên
        $sql = "SELECT p.* FROM products p 
                JOIN recently_viewed rv ON p.id = rv.product_id 
                GROUP BY p.id 
                ORDER BY COUNT(rv.id) DESC 
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT); // Ràng buộc kiểu số nguyên
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProducts($page, $limit, $category_id, $brand_id, $price_min, $price_max, $sort)
    {
        $offset = ($page - 1) * $limit;
        $where = [];
        $params = [];

        if ($category_id) {
            $where[] = "category_id = :category_id";
            $params[':category_id'] = $category_id;
        }
        if ($brand_id) {
            $where[] = "brand_id = :brand_id";
            $params[':brand_id'] = $brand_id;
        }
        if ($price_min) {
            $where[] = "price >= :price_min";
            $params[':price_min'] = $price_min;
        }
        if ($price_max) {
            $where[] = "price <= :price_max";
            $params[':price_max'] = $price_max;
        }

        $where_clause = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $sort_clause = $sort == 'price_asc' ? 'price ASC' : ($sort == 'price_desc' ? 'price DESC' : 'created_at DESC');

        $sql = "SELECT * FROM products $where_clause ORDER BY $sort_clause LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        // Bind các tham số WHERE
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        // Bind LIMIT và OFFSET
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalProducts($category_id, $brand_id, $price_min, $price_max)
    {
        $where = [];
        $params = [];

        if ($category_id) {
            $where[] = "category_id = ?";
            $params[] = $category_id;
        }
        if ($brand_id) {
            $where[] = "brand_id = ?";
            $params[] = $brand_id;
        }
        if ($price_min) {
            $where[] = "price >= ?";
            $params[] = $price_min;
        }
        if ($price_max) {
            $where[] = "price <= ?";
            $params[] = $price_max;
        }

        $where_clause = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $sql = "SELECT COUNT(*) FROM products $where_clause";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductAttributes($product_id)
    {
        $sql = "SELECT * FROM product_attributes WHERE product_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProducts($query, $category_id = 0, $limit = null)
    {
        $where = [];
        $params = [];

        if ($query) {
            $where[] = "(p.name LIKE :query OR c.name LIKE :query)";
            $params[':query'] = '%' . $query . '%';
        }
        if ($category_id) {
            $where[] = "p.category_id = :category_id";
            $params[':category_id'] = $category_id;
        }

        $where_clause = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            JOIN categories c ON p.category_id = c.id 
            $where_clause 
            ORDER BY p.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT :limit";
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        if ($limit) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($id)
    {
        $query = "SELECT p.*, c.name as category_name, b.name as brand_name 
                  FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  JOIN brands b ON p.brand_id = b.id 
                  WHERE p.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAttributes($product_id)
    {
        $query = "SELECT * FROM product_attributes WHERE product_id = :product_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll($page = 1, $items_per_page = ITEMS_PER_PAGE, $search = '')
    {
        $offset = ($page - 1) * $items_per_page;
        $query = "SELECT p.id, p.name, p.description, p.price, p.stock, c.name as category_name, b.name as brand_name 
                  FROM products p 
                  JOIN categories c ON p.category_id = c.id 
                  JOIN brands b ON p.brand_id = b.id";
        if ($search) {
            $query .= " WHERE p.name LIKE :search";
        }
        $query .= " ORDER BY p.created_at DESC LIMIT :offset, :items_per_page";

        $stmt = $this->pdo->prepare($query);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($search = '')
    {
        $query = "SELECT COUNT(*) FROM products";
        if ($search) {
            $query .= " WHERE name LIKE :search";
        }
        $stmt = $this->pdo->prepare($query);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function create($data)
    {
        $query = "INSERT INTO products (category_id, brand_id, name, description, price, stock, image, created_at, updated_at) 
                  VALUES (:category_id, :brand_id, :name, :description, :price, :stock, :image, NOW(), NOW())";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':brand_id', $data['brand_id'], PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':image', $data['image']);
        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $query = "UPDATE products 
                  SET category_id = :category_id, brand_id = :brand_id, name = :name, description = :description,
price = :price, stock = :stock, image = :image, updated_at = NOW() 
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':brand_id', $data['brand_id'], PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':image', $data['image']);
        return $stmt->execute();
    }

    public function delete($id)
    {
        // Kiểm tra xem sản phẩm có trong order_details không
        $checkQuery = "SELECT COUNT(*) FROM order_details WHERE product_id = :id";
        $checkStmt = $this->pdo->prepare($checkQuery);
        $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $checkStmt->execute();
        if ($checkStmt->fetchColumn() > 0) {
            throw new PDOException('Sản phẩm đang được sử dụng trong đơn hàng');
        }

        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addAttribute($product_id, $name, $value)
    {
        $query = "INSERT INTO product_attributes (product_id, attribute_name, attribute_value) 
                  VALUES (:product_id, :name, :value)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':value', $value);
        return $stmt->execute();
    }
    public function deleteAttributes($product_id)
    {
        $query = "DELETE FROM product_attributes WHERE product_id = :product_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}