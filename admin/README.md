# Admin Dashboard Documentation

## Overview

The Soumis Collections Admin Dashboard provides a modern, efficient interface for managing products, wholesale applications, and administrative tasks.

## Features

### 🎨 Modern UI/UX

- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Consistent Styling**: Unified color scheme and typography across all pages
- **Interactive Components**: Smooth animations and hover effects
- **Accessibility**: Semantic HTML and proper contrast ratios

### 📦 Product Management

- **Photo Uploads**: Upload product images with drag-and-drop support
- **Color Palette**: Quick-select color palette with custom color picker
- **Pricing Tiers**: Set separate retail and wholesale prices
- **Inventory Tracking**: Monitor stock quantities
- **Product Organization**: View and manage all products in one place

### 📋 Wholesale Applications

- **Application Tracking**: View all wholesale partnership requests
- **Contact Information**: Quick access to emails and phone numbers
- **Direct Communication**: One-click email and call shortcuts
- **Application Statistics**: Total and pending application counts

### 🔐 Security

- **Session-Based Authentication**: Secure admin login system
- **Email Verification**: Admin-only email whitelist
- **Proper Logout**: Clear session and cookies on logout

## File Structure

```
admin/
├── admin.css              # Main stylesheet for admin panel
├── index.php              # Dashboard homepage
├── products.php           # Product management interface
├── wholesale.php          # Wholesale applications viewer
├── logout.php             # Session termination
├── _auth.php              # Authentication middleware
└── utils.php              # Helper functions
```

## Getting Started

### Accessing the Admin Panel

1. Navigate to your login page
2. Use admin credentials:

   - **Email**: `admin@example.com`
   - **Password**: Any password (demo mode)

3. Click "Admin Login" to access the dashboard

### Dashboard Navigation

The admin header provides quick links to:

- **Dashboard**: Main overview and statistics
- **Product Management**: Add, edit, and manage products
- **Wholesale Applications**: Review partnership requests
- **Logout**: Securely exit the admin panel

## Key Features Explained

### Product Management

#### Adding a Product

1. Click "Manage Products" from the dashboard
2. Upload product photos using drag-and-drop or file browser
3. Fill in product details:

   - **Name**: Product title
   - **Description**: Detailed description
   - **Colors**: Select from palette or add custom colors
   - **Retail Price**: Customer-facing price
   - **Wholesale Price**: Bulk purchase price
   - **Stock**: Available quantity

4. Click "Save Product" to add to inventory

#### Color Selection

- **Quick Palette**: 18 pre-defined colors including:

  - Reds & Pinks
  - Oranges & Golds
  - Yellows & Greens
  - Teals & Cyans
  - Blues & Purples
  - Neutrals & Grays

- **Custom Picker**: Use the color input to select any color
- **Visual Preview**: See color samples before adding

#### Product Listing

View all products with:

- Retail and wholesale prices
- Stock levels
- Creation date
- Available colors
- Edit/Delete options

### Wholesale Applications

#### Viewing Applications

The wholesale page displays all partnership requests with:

- **Company Name**: Business name
- **Contact Person**: Name of requester
- **Email**: Direct contact email
- **Phone**: Phone number for calls
- **Message**: Request details
- **Timestamp**: When submitted

#### Quick Actions

- **Email Reply**: Opens default email client
- **Call**: Opens phone dialer
- **Delete**: Remove application record

#### Statistics

Dashboard shows:

- Total applications received
- Pending applications
- Recent submissions

## Customization

### Styling

Modify colors in `admin.css`:

- Primary color: `--primary-color: #d4af37`
- Dark color: `--dark-color: #2a2a2a`
- Light background: `--light-bg: #f7f5f2`

### Adding New Admin Users

Edit `config.php`:

```php
$ADMIN_EMAILS = [
  'admin@example.com',
  'newadmin@example.com'  // Add here
];
```

### Extending Features

Use `utils.php` helper functions:

- `getAdminStats()` - Get dashboard statistics
- `formatPrice()` - Format currency values
- `getHumanDate()` - Convert timestamps to readable format
- `sanitizeProduct()` - Clean product data
- `exportProductsCSV()` - Export product list

## Best Practices

### Security

✓ Always use HTTPS in production
✓ Implement proper password hashing
✓ Use environment variables for credentials
✓ Regularly audit admin access logs

### Maintenance

✓ Regularly backup product data
✓ Archive old wholesale applications
✓ Monitor image upload folder size
✓ Clean up unused product photos

### Performance

✓ Optimize product images before upload
✓ Limit wholesale applications list
✓ Use CDN for static assets
✓ Cache frequently accessed data

## Troubleshooting

### Images Not Uploading

- Ensure `images/` directory exists and is writable
- Check file size (max 5MB)
- Verify file type (JPEG, PNG, GIF, WebP)

### Products Not Saving

- Verify session is active
- Check form validation
- Ensure required fields are filled

### Applications Not Showing

- Check `wholesale_applications/` directory exists
- Verify JSON file permissions
- Ensure proper date format in JSON

## Future Enhancements

Planned features:

- [ ] Database integration for persistent storage
- [ ] Product image gallery
- [ ] Advanced filtering and search
- [ ] Bulk product import/export
- [ ] Application status tracking
- [ ] Email notification system
- [ ] Admin activity logging
- [ ] Mobile app integration

## Support

For issues or questions:

1. Check this documentation
2. Review code comments in files
3. Verify file permissions
4. Check browser console for errors

## Version History

**v2.0** (Current)

- Redesigned admin dashboard
- Modern CSS styling
- Enhanced product management
- Improved wholesale applications view
- Added utility functions
- Mobile responsive design

**v1.0**

- Basic admin functionality
- Simple product upload
- Application listing

---

**Last Updated**: December 21, 2025
**Maintained By**: Soumis Collections Development Team
