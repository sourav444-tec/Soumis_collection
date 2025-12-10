<?php
require_once __DIR__ . '/_auth.php';
$pageTitle = 'Product Management';

// Initialize products in session
if (!isset($_SESSION['products'])) {
  $_SESSION['products'] = [];
}

// Handle delete product
if (isset($_GET['delete'])) {
  $productId = $_GET['delete'];
  if (isset($_SESSION['products'][$productId])) {
    unset($_SESSION['products'][$productId]);
    header('Location: products.php?deleted=1');
    exit;
  }
}

// Handle file upload
$uploadMessage = '';
$uploadError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['product_photo'])) {
  $file = $_FILES['product_photo'];
  $uploadDir = __DIR__ . '/../images/';
  
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
  }
  
  $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
  $maxSize = 5 * 1024 * 1024; // 5MB
  
  if (in_array($file['type'], $allowedTypes)) {
    if ($file['size'] <= $maxSize) {
      $filename = time() . '_' . preg_replace('/[^a-z0-9._-]/i', '_', basename($file['name']));
      $uploadPath = $uploadDir . $filename;
      
      if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $uploadMessage = "Photo uploaded successfully: " . $filename;
      } else {
        $uploadError = "Failed to upload file. Please try again.";
      }
    } else {
      $uploadError = "File size exceeds 5MB limit.";
    }
  } else {
    $uploadError = "Invalid file type. Allowed: JPEG, PNG, GIF, WebP";
  }
}

// Handle product save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'])) {
  $productId = uniqid('prod_');
  $_SESSION['products'][$productId] = [
    'id' => $productId,
    'name' => htmlspecialchars($_POST['product_name']),
    'description' => htmlspecialchars($_POST['product_description']),
    'retail_price' => floatval($_POST['retail_price']),
    'wholesale_price' => floatval($_POST['wholesale_price']),
    'stock' => intval($_POST['stock_quantity']),
    'colors' => $_POST['colors'],
    'created' => date('Y-m-d H:i:s')
  ];
  header('Location: products.php?saved=1');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Playfair Display', Georgia, serif; background: #f7f5f2; }
    .admin-header { background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%); color: white; padding: 24px 32px; }
    .admin-header h1 { font-size: 28px; letter-spacing: 2px; margin-bottom: 8px; }
    .admin-header a { color: #d4af37; text-decoration: none; font-weight: 600; }
    .admin-container { max-width: 1000px; margin: 0 auto; padding: 32px 24px; }
    .form-section { background: white; padding: 28px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); margin-bottom: 24px; }
    .section-title { font-size: 20px; margin-bottom: 20px; color: #2a2a2a; letter-spacing: 1px; }
    .form-group { margin-bottom: 20px; }
    label { display: block; font-size: 14px; color: #7b776f; margin-bottom: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    input[type="text"],
    input[type="number"],
    textarea,
    select { width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px; font-family: inherit; }
    textarea { min-height: 100px; resize: vertical; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-row-three { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
    .color-picker-wrapper { position: relative; }
    .color-preview { display: inline-block; width: 50px; height: 50px; border-radius: 8px; border: 2px solid #e6e2dc; margin-top: 8px; cursor: pointer; }
    .photo-upload { border: 2px dashed #d4af37; border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: background 0.3s; }
    .photo-upload:hover { background: #faf8f5; }
    .photo-upload input[type="file"] { display: none; }
    .photo-upload-label { font-size: 14px; color: #7b776f; }
    .photo-preview { margin-top: 16px; max-width: 200px; }
    .photo-preview img { max-width: 100%; border-radius: 8px; }
    .btn-primary { background: linear-gradient(90deg, #d4af37, #e8c851); color: #2a2a2a; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; transition: opacity 0.3s; }
    .btn-primary:hover { opacity: 0.9; }
    .btn-secondary { background: #e6e2dc; color: #2a2a2a; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; margin-left: 8px; }
    .message { padding: 14px 16px; border-radius: 8px; margin-bottom: 20px; }
    .message.success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
    .message.error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
    .color-list { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 12px; }
    .color-chip { display: flex; align-items: center; gap: 8px; background: #f7f5f2; padding: 8px 12px; border-radius: 6px; border: 1px solid #e6e2dc; }
    .color-chip-swatch { width: 20px; height: 20px; border-radius: 4px; border: 1px solid #ccc; }
    .color-chip button { background: none; border: none; color: #d4af37; cursor: pointer; font-weight: bold; }
    .pricing-section { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .price-group { background: #f7f5f2; padding: 16px; border-radius: 8px; }
    .price-group label { margin-bottom: 8px; }
    .back-link { display: inline-block; margin-bottom: 24px; color: #d4af37; text-decoration: none; font-weight: 600; }
    .palette-btn { 
      width: 50px; 
      height: 50px; 
      border: none; 
      border-radius: 8px; 
      cursor: pointer; 
      transition: all 0.3s ease;
      transform: scale(1);
    }
    .palette-btn:hover { 
      transform: scale(1.15);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
    }
    .palette-btn:active { 
      transform: scale(0.95);
    }
  </style>
</head>
<body>
  <div class="admin-header">
    <h1>Product Management</h1>
    <p>Add and manage products with photos, colors, and pricing</p>
    <a href="index.php">← Back to Dashboard</a>
  </div>

  <div class="admin-container">
    <?php if ($uploadMessage): ?>
      <div class="message success"><?php echo htmlspecialchars($uploadMessage); ?></div>
    <?php endif; ?>
    <?php if ($uploadError): ?>
      <div class="message error"><?php echo htmlspecialchars($uploadError); ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['saved'])): ?>
      <div class="message success">✓ Product saved successfully!</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
      <div class="message success">✓ Product deleted successfully!</div>
    <?php endif; ?>

    <!-- Photo Upload Section -->
    <div class="form-section">
      <h2 class="section-title">📸 Upload Product Photo</h2>
      <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <div class="photo-upload" onclick="document.getElementById('photoInput').click()">
            <input type="file" id="photoInput" name="product_photo" accept="image/*" onchange="previewPhoto(this)" />
            <p class="photo-upload-label">📁 Click or drag photo here</p>
            <p style="font-size: 12px; color: #999; margin-top: 8px;">Max 5MB • JPEG, PNG, GIF, WebP</p>
            <div class="photo-preview">
              <img id="photoPreview" style="display: none;" />
            </div>
          </div>
        </div>
        <button type="submit" class="btn-primary">Upload Photo</button>
      </form>
    </div>

    <!-- Product Details Section -->
    <div class="form-section">
      <h2 class="section-title">📝 Product Details</h2>
      <form method="POST">
        <div class="form-group">
          <label for="product_name">Product Name</label>
          <input type="text" id="product_name" name="product_name" placeholder="e.g., Silk Saree Collection" required />
        </div>

        <div class="form-group">
          <label for="product_description">Description</label>
          <textarea id="product_description" name="product_description" placeholder="Product description and details..."></textarea>
        </div>

        <!-- Color Selection Section -->
        <div class="form-group">
          <label>Available Colors</label>
          
          <!-- Modern Color Palette -->
          <div style="margin-bottom: 24px; background: linear-gradient(135deg, #f7f5f2 0%, #faf8f5 100%); padding: 20px; border-radius: 12px; border: 2px solid #e6e2dc;">
            <p style="font-size: 12px; color: #7b776f; margin-bottom: 14px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">🎨 Quick Select Palette</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(50px, 1fr)); gap: 10px;">
              <!-- Reds & Pinks -->
              <button type="button" onclick="selectColor('#FF0000')" class="palette-btn" style="background: linear-gradient(135deg, #FF0000, #CC0000); box-shadow: 0 4px 12px rgba(255, 0, 0, 0.2);" title="Red"></button>
              <button type="button" onclick="selectColor('#FF6347')" class="palette-btn" style="background: linear-gradient(135deg, #FF6347, #FF4500); box-shadow: 0 4px 12px rgba(255, 99, 71, 0.2);" title="Tomato Red"></button>
              <button type="button" onclick="selectColor('#FFC0CB')" class="palette-btn" style="background: linear-gradient(135deg, #FFC0CB, #FFB6C1); box-shadow: 0 4px 12px rgba(255, 192, 203, 0.2);" title="Pink"></button>
              
              <!-- Oranges & Golds -->
              <button type="button" onclick="selectColor('#FFA500')" class="palette-btn" style="background: linear-gradient(135deg, #FFA500, #FF8C00); box-shadow: 0 4px 12px rgba(255, 165, 0, 0.2);" title="Orange"></button>
              <button type="button" onclick="selectColor('#D4AF37')" class="palette-btn" style="background: linear-gradient(135deg, #D4AF37, #C9A961); box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);" title="Gold"></button>
              <button type="button" onclick="selectColor('#DAA520')" class="palette-btn" style="background: linear-gradient(135deg, #DAA520, #CD853F); box-shadow: 0 4px 12px rgba(218, 165, 32, 0.2);" title="Goldenrod"></button>
              
              <!-- Yellows & Greens -->
              <button type="button" onclick="selectColor('#FFFF00')" class="palette-btn" style="background: linear-gradient(135deg, #FFFF00, #FFED4E); box-shadow: 0 4px 12px rgba(255, 255, 0, 0.3);" title="Yellow"></button>
              <button type="button" onclick="selectColor('#00FF00')" class="palette-btn" style="background: linear-gradient(135deg, #00FF00, #00CC00); box-shadow: 0 4px 12px rgba(0, 255, 0, 0.2);" title="Lime Green"></button>
              <button type="button" onclick="selectColor('#008000')" class="palette-btn" style="background: linear-gradient(135deg, #008000, #006600); box-shadow: 0 4px 12px rgba(0, 128, 0, 0.2);" title="Dark Green"></button>
              
              <!-- Teals & Cyans -->
              <button type="button" onclick="selectColor('#00FFFF')" class="palette-btn" style="background: linear-gradient(135deg, #00FFFF, #00CCFF); box-shadow: 0 4px 12px rgba(0, 255, 255, 0.3);" title="Cyan"></button>
              <button type="button" onclick="selectColor('#20B2AA')" class="palette-btn" style="background: linear-gradient(135deg, #20B2AA, #008B8B); box-shadow: 0 4px 12px rgba(32, 178, 170, 0.2);" title="Light Sea Green"></button>
              <button type="button" onclick="selectColor('#006666')" class="palette-btn" style="background: linear-gradient(135deg, #006666, #004444); box-shadow: 0 4px 12px rgba(0, 102, 102, 0.2);" title="Dark Teal"></button>
              
              <!-- Blues & Purples -->
              <button type="button" onclick="selectColor('#0000FF')" class="palette-btn" style="background: linear-gradient(135deg, #0000FF, #0000CC); box-shadow: 0 4px 12px rgba(0, 0, 255, 0.2);" title="Blue"></button>
              <button type="button" onclick="selectColor('#4169E1')" class="palette-btn" style="background: linear-gradient(135deg, #4169E1, #1E90FF); box-shadow: 0 4px 12px rgba(65, 105, 225, 0.2);" title="Royal Blue"></button>
              <button type="button" onclick="selectColor('#800080')" class="palette-btn" style="background: linear-gradient(135deg, #800080, #660066); box-shadow: 0 4px 12px rgba(128, 0, 128, 0.2);" title="Purple"></button>
              
              <!-- Neutrals -->
              <button type="button" onclick="selectColor('#FFFFFF')" class="palette-btn" style="background: linear-gradient(135deg, #FFFFFF, #F5F5F5); border: 3px solid #d4af37; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);" title="White"></button>
              <button type="button" onclick="selectColor('#C0C0C0')" class="palette-btn" style="background: linear-gradient(135deg, #C0C0C0, #A9A9A9); box-shadow: 0 4px 12px rgba(192, 192, 192, 0.2);" title="Silver"></button>
              <button type="button" onclick="selectColor('#808080')" class="palette-btn" style="background: linear-gradient(135deg, #808080, #666666); box-shadow: 0 4px 12px rgba(128, 128, 128, 0.3);" title="Gray"></button>
              
              <!-- Dark Colors -->
              <button type="button" onclick="selectColor('#A52A2A')" class="palette-btn" style="background: linear-gradient(135deg, #A52A2A, #8B0000); box-shadow: 0 4px 12px rgba(165, 42, 42, 0.2);" title="Brown"></button>
              <button type="button" onclick="selectColor('#000000')" class="palette-btn" style="background: linear-gradient(135deg, #2a2a2a, #000000); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);" title="Black"></button>
            </div>
          </div>

          <!-- Custom Color Picker Section -->
          <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #e6e2dc; margin-bottom: 16px;">
            <p style="font-size: 12px; color: #7b776f; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">✏️ Custom Color</p>
            <div style="display: flex; gap: 16px; align-items: center;">
              <input type="color" id="colorPicker" value="#d4af37" style="width: 60px; height: 60px; border: none; border-radius: 8px; cursor: pointer;" />
              <div style="flex: 1;">
                <div class="color-preview" id="colorPreview" style="background-color: #d4af37; width: 100%; height: 60px; border-radius: 8px; border: 2px solid #e6e2dc; box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);"></div>
              </div>
              <div style="display: flex; gap: 8px;">
                <input type="text" id="colorHex" value="#d4af37" style="width: 100px; padding: 8px 12px; border: 1px solid #e6e2dc; border-radius: 6px; font-family: monospace; font-size: 13px; text-transform: uppercase;" readonly />
                <button type="button" onclick="addColor()" class="btn-primary">+ Add</button>
              </div>
            </div>
          </div>

          <!-- Selected Colors Display -->
          <div style="background: #f7f5f2; padding: 16px; border-radius: 8px; border: 1px solid #e6e2dc;">
            <p style="font-size: 12px; color: #7b776f; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">📦 Selected Colors</p>
            <div class="color-list" id="colorList">
              <span style="color: #999; font-size: 13px;">No colors added yet</span>
            </div>
          </div>
          <input type="hidden" id="colorsData" name="colors" value="[]" />
        </div>

        <!-- Pricing Section -->
        <div class="form-group">
          <label>Pricing</label>
          <div class="pricing-section">
            <div class="price-group">
              <label for="retail_price">💎 Retail Price (per unit)</label>
              <input type="number" id="retail_price" name="retail_price" placeholder="e.g., 2999" step="0.01" required />
            </div>
            <div class="price-group">
              <label for="wholesale_price">🏪 Wholesale Price (per unit)</label>
              <input type="number" id="wholesale_price" name="wholesale_price" placeholder="e.g., 1499" step="0.01" required />
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="stock_quantity">Stock Quantity</label>
          <input type="number" id="stock_quantity" name="stock_quantity" placeholder="e.g., 50" required />
        </div>

        <button type="submit" class="btn-primary">Save Product</button>
        <a href="index.php" class="btn-secondary">Cancel</a>
      </form>
    </div>

    <!-- Products List Section -->
    <div class="form-section">
      <h2 class="section-title">📦 Saved Products (<?php echo count($_SESSION['products']); ?>)</h2>
      <?php if (empty($_SESSION['products'])): ?>
        <p style="color: #7b776f; font-size: 14px; text-align: center; padding: 40px 20px;">
          No products added yet. Create your first product above!
        </p>
      <?php else: ?>
        <div style="display: grid; gap: 16px;">
          <?php foreach ($_SESSION['products'] as $productId => $product): 
            $colors = json_decode($product['colors'], true) ?: [];
          ?>
            <div style="background: #f7f5f2; padding: 16px; border-radius: 8px; border: 1px solid #e6e2dc; display: grid; grid-template-columns: 1fr auto; gap: 16px; align-items: start;">
              <div>
                <h3 style="color: #2a2a2a; margin-bottom: 8px; font-size: 16px;"><?php echo $product['name']; ?></h3>
                <p style="color: #666; font-size: 13px; margin-bottom: 8px;"><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . (strlen($product['description']) > 100 ? '...' : ''); ?></p>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 12px; font-size: 13px;">
                  <div style="background: white; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #d4af37;">
                    <p style="color: #999; margin: 0 0 4px 0;">Retail Price</p>
                    <p style="color: #d4af37; font-weight: 600; font-size: 14px; margin: 0;">₹<?php echo number_format($product['retail_price'], 2); ?></p>
                  </div>
                  <div style="background: white; padding: 8px 12px; border-radius: 6px; border-left: 3px solid #d4af37;">
                    <p style="color: #999; margin: 0 0 4px 0;">Wholesale Price</p>
                    <p style="color: #d4af37; font-weight: 600; font-size: 14px; margin: 0;">₹<?php echo number_format($product['wholesale_price'], 2); ?></p>
                  </div>
                  <div style="background: white; padding: 8px 12px; border-radius: 6px;">
                    <p style="color: #999; margin: 0 0 4px 0;">Stock</p>
                    <p style="color: #2a2a2a; font-weight: 600; font-size: 14px; margin: 0;"><?php echo $product['stock']; ?> units</p>
                  </div>
                  <div style="background: white; padding: 8px 12px; border-radius: 6px;">
                    <p style="color: #999; margin: 0 0 4px 0;">Added</p>
                    <p style="color: #2a2a2a; font-weight: 600; font-size: 13px; margin: 0;"><?php echo date('M d, Y', strtotime($product['created'])); ?></p>
                  </div>
                </div>

                <?php if (!empty($colors)): ?>
                  <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                    <?php foreach ($colors as $color): ?>
                      <div style="width: 24px; height: 24px; background-color: <?php echo $color; ?>; border-radius: 4px; border: 1px solid #ccc;" title="<?php echo $color; ?>"></div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>

              <!-- Action Buttons -->
              <div style="display: flex; flex-direction: column; gap: 8px;">
                <button type="button" class="btn-primary" onclick="editProduct('<?php echo $productId; ?>')" style="padding: 8px 12px; font-size: 12px; white-space: nowrap;">✏️ Edit</button>
                <button type="button" class="btn-secondary" onclick="deleteProduct('<?php echo $productId; ?>', '<?php echo $product['name']; ?>')" style="padding: 8px 12px; font-size: 12px; white-space: nowrap; background: #e74c3c; color: white;">🗑️ Delete</button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
  <script>
    let colors = [];

    // Initialize color picker
    document.getElementById('colorPicker').addEventListener('change', function() {
      document.getElementById('colorPreview').style.backgroundColor = this.value;
      document.getElementById('colorHex').value = this.value.toUpperCase();
    });

    // Select color from palette
    function selectColor(color) {
      document.getElementById('colorPicker').value = color;
      document.getElementById('colorPreview').style.backgroundColor = color;
      document.getElementById('colorHex').value = color.toUpperCase();
    }

    // Preview photo before upload
    function previewPhoto(input) {
      const preview = document.getElementById('photoPreview');
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    // Add color to list
    function addColor() {
      const colorPicker = document.getElementById('colorPicker');
      const color = colorPicker.value;
      
      if (!colors.includes(color)) {
        colors.push(color);
        updateColorList();
      }
    }

    // Update color list display
    function updateColorList() {
      const colorList = document.getElementById('colorList');
      const colorsData = document.getElementById('colorsData');
      
      if (colors.length === 0) {
        colorList.innerHTML = '<span style="color: #999; font-size: 13px;">No colors added yet</span>';
      } else {
        colorList.innerHTML = colors.map((color, index) => `
          <div class="color-chip">
            <div class="color-chip-swatch" style="background-color: ${color}; box-shadow: 0 2px 6px rgba(0,0,0,0.1);"></div>
            <span style="font-size: 13px; color: #666; font-weight: 500;">${color.toUpperCase()}</span>
            <button type="button" onclick="removeColor(${index})" style="color: #e74c3c; font-size: 18px;">×</button>
          </div>
        `).join('');
      }
      
      colorsData.value = JSON.stringify(colors);
    }

    // Remove color from list
    function removeColor(index) {
      colors.splice(index, 1);
      updateColorList();
    }

    // Delete product
    function deleteProduct(productId, productName) {
      const confirmed = confirm('Are you sure you want to delete "' + productName + '"?\n\nThis action cannot be undone.');
      if (confirmed) {
        window.location.href = 'products.php?delete=' + productId;
      }
    }

    // Edit product (placeholder for future implementation)
    function editProduct(productId) {
      alert('Edit functionality coming soon!\nProduct ID: ' + productId);
      // Future: window.location.href = 'edit-product.php?id=' + productId;
    }

    // Drag and drop for photo upload
    const photoUpload = document.querySelector('.photo-upload');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      photoUpload.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }

    photoUpload.addEventListener('drop', function(e) {
      const dt = e.dataTransfer;
      const files = dt.files;
      document.getElementById('photoInput').files = files;
      previewPhoto(document.getElementById('photoInput'));
    });
  </script>
</body>
</html>
