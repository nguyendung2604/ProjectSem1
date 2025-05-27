<?php
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/admin/css/style.css">
</head>
<body>
    <div class="admin-header">
        <div class="container-fluid">
            <h1>Admin Page</h1>
            <div class="breadcrumb-nav">
                <i class="fas fa-home"></i> <a href="#">Home</a> / <span class="current">Admin</span>
            </div>
        </div>
    </div>