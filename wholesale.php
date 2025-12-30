<?php
session_start();
$pageTitle = 'Soumis Collections — Wholesale';
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<section class="detail-page" style="padding-top:40px">
  <div class="detail-header">
    <a class="detail-back" href="index.php" aria-label="Back to home">&larr; Home</a>
    <h1>Wholesale & Bulk Orders</h1>
    <p class="detail-tagline">Buy in bulk with exclusive wholesale pricing. Minimum order quantities apply for better rates.</p>
  </div>
  <div class="detail-content">
    <!-- Pricing Tiers Section -->
    <div class="detail-section" style="background: #f7f5f2; padding: 28px; border-radius: 12px; margin-bottom: 28px;">
      <h2 style="margin-bottom: 20px;">💰 Wholesale Pricing Tiers</h2>
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
        <!-- Tier 1 -->
        <div style="background: white; padding: 20px; border-radius: 10px; border: 2px solid #e6e2dc; transition: all 0.3s;">
          <h3 style="color: #d4af37; margin-bottom: 12px;">🎯 Starter</h3>
          <p style="font-size: 13px; color: #7b776f; margin-bottom: 12px;">Minimum Order: <strong>10 units</strong></p>
          <div style="background: #f0ede8; padding: 12px; border-radius: 6px; margin-bottom: 12px;">
            <p style="font-size: 12px; color: #666; margin: 0;">Discount: <strong>10%</strong></p>
            <p style="font-size: 12px; color: #666; margin: 4px 0 0 0;">Price per unit from ₹899</p>
          </div>
          <ul style="font-size: 12px; color: #555; list-style: none; padding: 0;">
            <li>✓ Standard packaging</li>
            <li>✓ 5-7 day delivery</li>
            <li>✓ Email support</li>
          </ul>
        </div>

        <!-- Tier 2 -->
        <div style="background: white; padding: 20px; border-radius: 10px; border: 3px solid #d4af37; transform: scale(1.05); box-shadow: 0 8px 20px rgba(212, 175, 55, 0.2);">
          <span style="background: #d4af37; color: #2a2a2a; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; display: inline-block; margin-bottom: 8px;">POPULAR</span>
          <h3 style="color: #d4af37; margin: 8px 0 12px 0;">⭐ Professional</h3>
          <p style="font-size: 13px; color: #7b776f; margin-bottom: 12px;">Minimum Order: <strong>50 units</strong></p>
          <div style="background: #faf8f5; padding: 12px; border-radius: 6px; margin-bottom: 12px; border: 1px solid #d4af37;">
            <p style="font-size: 12px; color: #666; margin: 0;">Discount: <strong>20%</strong></p>
            <p style="font-size: 12px; color: #666; margin: 4px 0 0 0;">Price per unit from ₹719</p>
          </div>
          <ul style="font-size: 12px; color: #555; list-style: none; padding: 0;">
            <li>✓ Custom packaging</li>
            <li>✓ 3-4 day delivery</li>
            <li>✓ Priority support</li>
          </ul>
        </div>

        <!-- Tier 3 -->
        <div style="background: white; padding: 20px; border-radius: 10px; border: 2px solid #e6e2dc;">
          <h3 style="color: #d4af37; margin-bottom: 12px;">🏆 Enterprise</h3>
          <p style="font-size: 13px; color: #7b776f; margin-bottom: 12px;">Minimum Order: <strong>200+ units</strong></p>
          <div style="background: #f0ede8; padding: 12px; border-radius: 6px; margin-bottom: 12px;">
            <p style="font-size: 12px; color: #666; margin: 0;">Discount: <strong>30%+</strong></p>
            <p style="font-size: 12px; color: #666; margin: 4px 0 0 0;">Price per unit from ₹559</p>
          </div>
          <ul style="font-size: 12px; color: #555; list-style: none; padding: 0;">
            <li>✓ Branded packaging</li>
            <li>✓ 2-3 day delivery</li>
            <li>✓ Dedicated manager</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Bulk Order Form Section -->
    <div class="detail-section" style="background: white; padding: 28px; border-radius: 12px; border: 1px solid #e6e2dc;">
      <h2 style="margin-bottom: 20px;">📦 Place a Bulk Order</h2>
      <?php if (isset($_GET['order_status']) && $_GET['order_status']==='success'): ?>
        <div style="background: #e8f5e9; color: #2e7d32; padding: 14px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c8e6c9;">
          ✓ Order placed successfully! Our team will contact you within 24 hours to confirm details.
        </div>
      <?php endif; ?>
      
      <form action="process-wholesale.php" method="post" style="display: grid; gap: 20px;">
        <?php if (isset($_GET['status']) && $_GET['status']==='error'): ?>
          <?php 
            $errorMsg = 'Please fill all required fields.';
            if (isset($_GET['message'])) {
              if ($_GET['message'] === 'minimum_products') {
                $errorMsg = 'Minimum 6 products required per order.';
              } elseif ($_GET['message'] === 'minimum_amount') {
                $errorMsg = 'Minimum purchase amount is ₹500.';
              }
            }
          ?>
          <div style="background: #ffebee; color: #c62828; padding: 14px 16px; border-radius: 8px; border: 1px solid #ef5350;">
            ✗ Error: <?php echo $errorMsg; ?>
          </div>
        <?php endif; ?>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div>
            <label for="company" style="display: block; font-size: 13px; margin-bottom: 6px; color: #7b776f; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Company Name</label>
            <input id="company" name="company" type="text" required placeholder="Your company name" style="width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px;" />
          </div>
          <div>
            <label for="contact" style="display: block; font-size: 13px; margin-bottom: 6px; color: #7b776f; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Contact Name</label>
            <input id="contact" name="contact" type="text" required placeholder="Full name" style="width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px;" />
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div>
            <label for="email" style="display: block; font-size: 13px; margin-bottom: 6px; color: #7b776f; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Business Email</label>
            <input id="email" name="email" type="email" required placeholder="you@business.com" style="width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px;" />
          </div>
          <div>
            <label for="phone" style="display: block; font-size: 13px; margin-bottom: 6px; color: #7b776f; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Phone Number</label>
            <input id="phone" name="phone" type="text" required placeholder="+91 XXXXX XXXXX" style="width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px;" />
          </div>
        </div>

        <div>
          <label for="product_interest" style="display: block; font-size: 13px; margin-bottom: 6px; color: #7b776f; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Products of Interest</label>
          <select id="product_interest" name="product_interest" required style="width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px;">
            <option value="">Select a product category</option>
            <option value="sarees">Traditional Sarees</option>
            <option value="lehengas">Lehengas & Cholis</option>
            <option value="salwar">Salwar Kameez</option>
            <option value="ethnic">Ethnic Wear</option>
            <option value="mixed">Mixed Assortment</option>
          </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div>
            <label for="quantity" style="display: block; font-size: 13px; margin-bottom: 6px; color: #7b776f; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Order Quantity (units)</label>
            <input id="quantity" name="quantity" type="number" min="6" step="1" required placeholder="Minimum 6 products" style="width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px;" />
            <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Minimum 6 products required | Starter: 10+ | Professional: 50+ | Enterprise: 200+</small>
          </div>
          <div>
            <label for="purchase_amount" style="display: block; font-size: 13px; margin-bottom: 6px; color: #7b776f; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Minimum Purchase Amount (₹)</label>
            <input id="purchase_amount" name="purchase_amount" type="number" min="500" step="1" required placeholder="Minimum ₹500" style="width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px;" />
            <small style="color: #999; font-size: 12px; display: block; margin-top: 4px;">Minimum purchase value: ₹500</small>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
          <div>
            <label for="price_tier" style="display: block; font-size: 13px; margin-bottom: 6px; color: #7b776f; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Applicable Discount</label>
            <select id="price_tier" name="price_tier" style="width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px; background: #f7f5f2;" disabled>
              <option value="">Select tier based on quantity</option>
              <option value="10">10-49 units (10% off)</option>
              <option value="50">50-199 units (20% off)</option>
              <option value="200">200+ units (30% off)</option>
            </select>
          </div>
        </div>

        <div>
          <label for="message" style="display: block; font-size: 13px; margin-bottom: 6px; color: #7b776f; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Additional Notes / Special Requests</label>
          <textarea id="message" name="message" rows="5" placeholder="Tell us about your store, location, and any specific requirements..." style="width: 100%; padding: 12px 14px; border: 1px solid #e6e2dc; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit;"></textarea>
        </div>

        <div style="background: #f7f5f2; padding: 14px 16px; border-radius: 8px; border-left: 4px solid #d4af37;">
          <p style="font-size: 13px; color: #555; margin: 0;">
            <strong>Terms:</strong> All wholesale orders are subject to verification. We'll contact you within 24 hours to confirm availability and finalize pricing.
          </p>
        </div>

        <button type="submit" style="background: linear-gradient(90deg, #d4af37, #e8c851); color: #2a2a2a; padding: 14px 24px; border: none; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; transition: opacity 0.3s;">
          Submit Bulk Order Request
        </button>
      </form>
    </div>

    <!-- Benefits Section -->
    <div class="detail-section">
      <h2 style="margin-bottom: 16px;">✨ Why Choose Wholesale with Us?</h2>
      <ul style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px; list-style: none; padding: 0;">
        <li style="background: #f7f5f2; padding: 16px; border-radius: 8px; border-left: 4px solid #d4af37;">
          <strong style="color: #d4af37;">📦 Minimum Order Requirements</strong>
          <p style="font-size: 13px; color: #555; margin-top: 6px;">Minimum 6 products with ₹500 purchase value. Scale up for tiered discounts.</p>
        </li>
        <li style="background: #f7f5f2; padding: 16px; border-radius: 8px; border-left: 4px solid #d4af37;">
          <strong style="color: #d4af37;">🚚 Fast Fulfillment</strong>
          <p style="font-size: 13px; color: #555; margin-top: 6px;">Quick shipping with dedicated resail option and section support.</p>
        </li>
        <li style="background: #f7f5f2; padding: 16px; border-radius: 8px; border-left: 4px solid #d4af37;">
          <strong style="color: #d4af37;">💳 Flexible Payment</strong>
          <p style="font-size: 13px; color: #555; margin-top: 6px;">Multiple payment options and net payment terms available.</p>
        </li>
        <li style="background: #f7f5f2; padding: 16px; border-radius: 8px; border-left: 4px solid #d4af37;">
          <strong style="color: #d4af37;">👥 Dedicated Support</strong>
          <p style="font-size: 13px; color: #555; margin-top: 6px;">Get assigned an account manager for large orders.</p>
        </li>
        <li style="background: #f7f5f2; padding: 16px; border-radius: 8px; border-left: 4px solid #d4af37;">
          <strong style="color: #d4af37;">🎁 Custom Packaging</strong>
          <p style="font-size: 13px; color: #555; margin-top: 6px;">Branded boxes and packaging options available.</p>
        </li>
        <li style="background: #f7f5f2; padding: 16px; border-radius: 8px; border-left: 4px solid #d4af37;">
          <strong style="color: #d4af37;">📈 Repeat Incentives</strong>
          <p style="font-size: 13px; color: #555; margin-top: 6px;">Loyalty rewards and seasonal promotions.</p>
        </li>
      </ul>
    </div>

    <!-- FAQ Section -->
    <div class="detail-section" style="background: #f7f5f2; padding: 28px; border-radius: 12px;">
      <h2 style="margin-bottom: 20px;">❓ Frequently Asked Questions</h2>
      <div style="display: grid; gap: 16px;">
        <div>
          <h4 style="color: #d4af37; margin-bottom: 6px;">What is the minimum order quantity?</h4>
          <p style="color: #555; font-size: 13px; margin: 0;">Minimum 6 products per order. For tiered pricing: Starter 10+ units, Professional 50+ units, Enterprise 200+ units. Minimum purchase value is ₹500.</p>
        </div>
        <div>
          <h4 style="color: #d4af37; margin-bottom: 6px;">How long does delivery take?</h4>
          <p style="color: #555; font-size: 13px; margin: 0;">Orders ship within 2-7 days depending on your tier. Express shipping available on request.</p>
        </div>
        <div>
          <h4 style="color: #d4af37; margin-bottom: 6px;">Do you offer custom packaging?</h4>
          <p style="color: #555; font-size: 13px; margin: 0;">Yes! Professional and Enterprise tiers include custom packaging options.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
        </div>
        <button class="btn btn-primary" type="submit" style="width:100%">Submit Application</button>
        <p style="font-size:12px;color:#777">Submission is demo-only; no data leaves this server.</p>
      </form>
    </div>
    <div class="detail-section">
      <h2>Pricing Tiers</h2>
      <p style="color:#555">Typical structure (example only):</p>
      <ul>
        <li>Tier 1: 25+ units – 10% off</li>
        <li>Tier 2: 50+ units – 18% off</li>
        <li>Tier 3: 100+ units – 25% off</li>
        <li>Tier 4: 250+ units – 32% off</li>
      </ul>
      <p style="color:#777;font-size:12px;margin-top:8px">Exact discounts depend on collection and materials.</p>
    </div>
  </div>
  <div class="detail-footer">
    <p>Questions? <a href="mailto:wholesale@soumis.local" style="color:inherit;text-decoration:underline">Contact wholesale support</a></p>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
