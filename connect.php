<?php
try {
  // host=XXXの部分のXXXにはmysqlのサービス名を指定します
  $dsn = 'mysql:host=db;dbname=' . $_ENV['DB_NAME'] . ';';
  $db = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);

  $sql = 'SELECT version();';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  var_dump($result);
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}