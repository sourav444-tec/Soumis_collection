# Soumis Collections - E-Commerce Jewelry Platform

## 🏢 Developed by ROYAL TECH

**Development Team:**

- **SOURAV SANYAL** (Computer Application) - Back-end & Server-side Development
- **HRITHIKA ROY** (Computer Application) - Front-end Design & Development

---

## 📋 Project Overview

Soumis Collections is a modern, full-featured e-commerce platform specializing in handcrafted jewelry. The website offers a comprehensive product management system, multi-language support, dark mode, and an intuitive admin panel for managing inventory and customer orders.

## ✨ Key Features

### 🛍️ Customer Features

- **Product Catalog**: Browse complete collection with 8 jewelry categories
- **Advanced Filtering**: Filter by category, price range, and sort options
- **Multiple Display Sections**:
  - 🆕 New Arrivals
  - 🔥 Best Sellers
  - ✨ Unique Collections
- **Product Details**: View images, colors, pricing (retail & wholesale), and stock availability
- **User Authentication**: Secure login/signup with OTP support
- **User Dashboard**: Profile management, order tracking, wishlist
- **Dark Mode**: Toggle between light and dark themes
- **Multi-Language Support**: English, Bengali, Hindi, Gujarati, Tamil
- **Responsive Design**: Optimized for desktop, tablet, and mobile devices
- **Wholesale Portal**: Business partnership application system

### 👨‍💼 Admin Features

- **Comprehensive Dashboard**: Real-time statistics and analytics
- **Product Management**:
  - Add/Edit/Delete products
  - Image upload (max 5MB)
  - Category assignment (8 categories)
  - Section assignment (3 display sections)
  - Color palette picker (20+ preset colors + custom)
  - Retail & wholesale pricing
  - Stock management
- **Stock Alerts**: Automatic low stock and out-of-stock warnings
- **Recent Products**: Track latest additions
- **Statistics Tracking**:
  - Total products and inventory value
  - Products by category
  - Products by display section
  - Stock status overview
- **Wholesale Management**: Review business applications
- **Quick Actions**: Fast access to all management tools

## 📂 Project Structure

```
Soumis_collection/
├── admin/                      # Admin panel
│   ├── index.php              # Dashboard with statistics
│   ├── products.php           # Product management
│   ├── wholesale.php          # Wholesale applications
│   ├── admin.css              # Admin styling
│   ├── _auth.php              # Authentication guard
│   └── logout.php             # Logout handler
├── includes/                   # Reusable components
│   ├── header.php             # Site header
│   ├── nav.php                # Navigation menu
│   └── footer.php             # Site footer
├── images/                     # Image assets
│   └── products/              # Product images directory
├── index.php                   # Homepage
├── products.php                # All products with filters
├── new-arrivals.php           # New arrivals section
├── best-sellers.php           # Best sellers section
├── unique-collections.php     # Unique collections
├── login.php                   # User login
├── signup.php                  # User registration
├── profile.php                 # User profile
├── orders.php                  # Order history
├── wishlist.php                # User wishlist
├── settings.php                # User settings
├── wholesale.php               # Wholesale information
├── cart.php                    # Shopping cart
├── style.css                   # Main stylesheet
├── dark-mode.css              # Dark theme stylesheet
├── login.css                   # Login/signup styling
├── lang.php                    # Language translations
└── config.php                  # Configuration file
```

## 🎨 Product Categories

1. 💎 **Earrings** - Studs, hoops, danglers
2. 📿 **Necklace** - Chains, pendants, chokers
3. ⭕ **Bangles** - Traditional and modern designs
4. 💍 **Rings** - Engagement, fashion, statement
5. 🔆 **Pendants** - Religious, fashion, personalized
6. 🔗 **Bracelets** - Chain, charm, cuff
7. 👣 **Anklets** - Traditional payal designs
8. 👃 **Nose Rings** - Studs and hoops

## 🔧 Technical Stack

### Frontend

- **HTML5** - Semantic markup
- **CSS3** - Modern styling with CSS variables
- **JavaScript** - Interactive features and dark mode
- **Responsive Design** - Mobile-first approach

### Backend

- **PHP 7.4+** - Server-side logic
- **Session Management** - User authentication and data storage
- **File Upload System** - Image handling

### Features Implementation

- **Color Picker** - Spectrum.js integration
- **Image Upload** - Drag & drop support
- **Price Range Slider** - Dual range inputs
- **Stock Management** - Real-time tracking
- **Multi-language** - Translation system

## 🚀 Installation & Setup

### Prerequisites

- XAMPP/WAMP/LAMP server
- PHP 7.4 or higher
- Web browser (Chrome, Firefox, Safari, Edge)

### Installation Steps

1. **Clone/Download the repository**

   ```bash
   git clone https://github.com/sourav444-tec/Soumis_collection.git
   ```

2. **Move to XAMPP directory**

   ```bash
   # Windows
   C:\xampp\htdocs\Soumis_collection

   # Linux/Mac
   /opt/lampp/htdocs/Soumis_collection
   ```

3. **Start Apache Server**

   - Open XAMPP Control Panel
   - Start Apache

4. **Access the website**

   ```
   http://localhost/Soumis_collection/
   ```

5. **Admin Login**
   ```
   Email: admin@example.com
   Password: (any password works in demo mode)
   ```

## 📱 Pages & Routes

### Public Pages

- `/` - Homepage with featured sections
- `/products.php` - All products with filters
- `/new-arrivals.php` - Latest products
- `/best-sellers.php` - Popular products
- `/unique-collections.php` - Exclusive designs
- `/wholesale.php` - Business partnerships
- `/login.php` - User login
- `/signup.php` - User registration

### User Pages (Authentication Required)

- `/profile.php` - User profile management
- `/orders.php` - Order history
- `/wishlist.php` - Saved products
- `/settings.php` - Language & theme preferences
- `/cart.php` - Shopping cart

### Admin Pages (Admin Access Only)

- `/admin/index.php` - Dashboard
- `/admin/products.php` - Product management
- `/admin/wholesale.php` - Application reviews

## 🎯 Core Functionalities

### Product Management

1. **Add Product**: Upload image, set details, assign category/sections
2. **Color Selection**: Choose from 20+ preset colors or create custom
3. **Pricing**: Set retail and wholesale prices
4. **Stock Tracking**: Monitor inventory levels
5. **Multi-Section Display**: Show products in multiple locations

### User Management

1. **Registration**: Email-based signup
2. **Login**: Secure authentication with OTP option
3. **Profile**: Manage personal information
4. **Orders**: Track order history
5. **Wishlist**: Save favorite products
6. **Settings**: Language and theme preferences

### Admin Dashboard

1. **Statistics**: Real-time product and inventory metrics
2. **Category View**: Products grouped by type
3. **Section View**: Products by display location
4. **Stock Alerts**: Low stock warnings
5. **Recent Activity**: Latest product additions

## 🌙 Dark Mode

- **Toggle**: Bottom-right floating button (🌙/☀️)
- **Persistence**: Saved in localStorage
- **Auto-detection**: System preference support
- **Full Coverage**: All pages styled for dark mode

## 🌍 Multi-Language Support

**Available Languages:**

1. English (Default)
2. বাংলা (Bengali)
3. हिन्दी (Hindi)
4. ગુજરાતી (Gujarati)
5. தமிழ் (Tamil)

**How to Use:**

- Go to Settings page
- Select preferred language
- Page reloads with new language

## 🔒 Security Features

- Session-based authentication
- Admin access protection
- SQL injection prevention (when DB integrated)
- XSS protection with htmlspecialchars()
- File upload validation
- Input sanitization

## 📊 Admin Statistics

The admin dashboard displays:

- Total products in catalog
- Total stock units
- Total inventory value (₹)
- Stock alerts (low/out of stock)
- Products per category
- Products per display section
- Recent product additions
- Stock status breakdown

## 🎨 Design Features

- **Color Scheme**: Gold (#d4af37) primary color
- **Typography**: Modern, readable fonts
- **Layout**: Grid-based responsive design
- **Icons**: Emoji-based visual indicators
- **Animations**: Smooth transitions and hover effects
- **Cards**: Modern card-based UI components

## 📝 Future Enhancements

### Planned Features

- [ ] MySQL database integration
- [ ] Payment gateway (Razorpay/Stripe)
- [ ] Email notifications
- [ ] Product reviews and ratings
- [ ] Advanced search with autocomplete
- [ ] Order management system
- [ ] Invoice generation
- [ ] Shipping integration
- [ ] Customer support chat
- [ ] Analytics dashboard
- [ ] SEO optimization
- [ ] Product comparison
- [ ] Gift card system

## 🐛 Known Issues

- Data stored in sessions (clears on logout)
- No persistent database (currently session-based)
- Cart functionality placeholder
- Product edit feature in development

## 📞 Support & Contact

**Development Team:**

- **SOURAV SANYAL** - Back-end & Server-side Development
- **HRITHIKA ROY** - Front-end Design & Development

**Organization:** ROYAL TECH

**Repository:** [GitHub - Soumis Collections](https://github.com/sourav444-tec/Soumis_collection.git)

## 📄 License

This project is developed by ROYAL TECH. All rights reserved.

## 🙏 Acknowledgments

- XAMPP for local development environment
- Spectrum.js for color picker functionality
- All open-source libraries used in this project

## 📅 Version History

### Version 1.0.0 (December 2025)

- Initial release
- Product management system
- Multi-language support
- Dark mode implementation
- Admin dashboard with statistics
- User authentication and profiles
- Responsive design
- 8 product categories
- 3 display sections
- Advanced filtering system

---

**Developed with ❤️ by ROYAL TECH**

**Developers:** SOURAV SANYAL & HRITHIKA ROY

**© 2025 Soumis Collections. All Rights Reserved.**
