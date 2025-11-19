<div class="card">
    <div class="card-header card-header-white">
        <h6 class="mb-0">All Products (<?php echo number_format($totalItems); ?> items)</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive-2d">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Part Code</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><strong>PI-<?php echo $product['ID']; ?></strong></td>
                            <td><?php echo htmlspecialchars($product['ProductName']); ?></td>
                            <td>
                                <a href="javascript:void(0)" onclick="showImageModal('<?php echo htmlspecialchars($product['Image']); ?>')">
                                    <img src="<?php echo htmlspecialchars($product['Image']); ?>" width="60" height="60" style="object-fit:cover; border-radius:8px; border:2px solid #eee;">
                                </a>
                            </td>
                            <td><strong>Tsh <?php echo number_format($product['prod_price'], 2); ?></strong></td>
                            <td>
                                <?php echo $product['Quantity']; ?>
                                <?php if ($product['Quantity'] < 5): ?>
                                    <span class="low-stock ms-2">Low Stock</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($product['Description']); ?></td>
                            <td><span class="badge bg-primary"><?php echo htmlspecialchars($product['prod_cat']); ?></span></td>
                            <td><?php echo date('d M Y', strtotime($product['AddedDate'])); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['ID']; ?>" class="btn btn-sm btn-info mb-1">Edit</a>
                                <a href="delete_product.php?id=<?php echo $product['ID']; ?>" class="btn btn-sm btn-danger mb-1" 
                                   onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No products found matching the criteria.</h5>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>