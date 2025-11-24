<?php
session_start();
$pageTitle = 'Soumis Collections — Wholesale';
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>
<section class="detail-page" style="padding-top:40px">
  <div class="detail-header">
    <a class="detail-back" href="index.php" aria-label="Back to home">&larr; Home</a>
    <h1>Wholesale Partnership</h1>
    <p class="detail-tagline">Apply to carry Soumis Collections in your retail store and access tiered pricing, early releases, and dedicated support.</p>
  </div>
  <div class="detail-content">
    <div class="detail-section">
      <h2>Benefits</h2>
      <ul>
        <li>Tiered volume pricing</li>
        <li>Early access to new arrivals</li>
        <li>Custom packaging options</li>
        <li>Dedicated account manager</li>
        <li>Fast fulfillment & dropship options</li>
      </ul>
    </div>
    <div class="detail-section">
      <h2>Apply Now</h2>
      <?php if (isset($_GET['status']) && $_GET['status']==='sent'): ?>
        <p style="color:green;font-size:14px;margin-bottom:16px">Application received. We will review and contact you (demo flow).</p>
      <?php endif; ?>
      <form action="process-wholesale.php" method="post" style="display:grid;gap:14px">
        <div>
          <label for="company" style="display:block;font-size:13px;margin-bottom:4px;color:#555">Company Name</label>
          <input id="company" name="company" type="text" required placeholder="Your company" style="width:100%;padding:12px 14px;border:1px solid #e6e2dc;border-radius:8px" />
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
          <div>
            <label for="contact" style="display:block;font-size:13px;margin-bottom:4px;color:#555">Contact Name</label>
            <input id="contact" name="contact" type="text" required placeholder="Full name" style="width:100%;padding:12px 14px;border:1px solid #e6e2dc;border-radius:8px" />
          </div>
          <div>
            <label for="phone" style="display:block;font-size:13px;margin-bottom:4px;color:#555">Phone</label>
            <input id="phone" name="phone" type="text" required placeholder="+1 XXX" style="width:100%;padding:12px 14px;border:1px solid #e6e2dc;border-radius:8px" />
          </div>
        </div>
        <div>
          <label for="email" style="display:block;font-size:13px;margin-bottom:4px;color:#555">Business Email</label>
          <input id="email" name="email" type="email" required placeholder="you@business.com" style="width:100%;padding:12px 14px;border:1px solid #e6e2dc;border-radius:8px" />
        </div>
        <div>
          <label for="message" style="display:block;font-size:13px;margin-bottom:4px;color:#555">Message / Notes</label>
          <textarea id="message" name="message" rows="4" placeholder="Tell us about your store" style="width:100%;padding:12px 14px;border:1px solid #e6e2dc;border-radius:8px;resize:vertical"></textarea>
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
