# Smart Bus Portal

> Real-time Bus Tracking & Attendance Management System for Tamil Nadu

## 🚀 Quick Start

### New System Setup (3 Simple Steps)

1. **Install XAMPP** → Start Apache + MySQL
2. **Import Database** → Run `database_setup.sql` in phpMyAdmin  
3. **Access Portal** → Open `http://localhost/smart-bus-portal/public/index.php`

📖 **Full Instructions:** See [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)

## 📁 Key Files

| File | Purpose |
|------|---------|
| `database_setup.sql` | Complete database setup (all tables + data) |
| `DEPLOYMENT_GUIDE.md` | Step-by-step deployment instructions |
| `public/db.php` | Database connection config |
| `public/index.php` | Application homepage |

## 🎯 Default Login Credentials

### Staff Portal (Platform Incharge)
```
Any district: username: `[district]_admin`, password: `admin`
Example: 
  District: Madurai
  Username: madurai_admin
  Password: admin
```

### Passenger Portal
Sign up with mobile number (no password required)

## 🗄️ Database Info

- **Name:** `smart_bus_portal`
- **Tables:** 6 (buses, attendance, platform_incharges, passengers, special_buses, feedback)
- **Initial Data:** 38 platform incharge accounts (all Tamil Nadu districts)
- **Encoding:** UTF-8MB4 (supports Tamil, Hindi)

## ✨ Features

- ✅ 17 Premium Themes (Executive, Corporate, Ocean, Forest, etc.)
- ✅ Multi-language (English, Tamil, Hindi)
- ✅ Real-time Bus Status & Attendance
- ✅ AI Chatbot for Bus Search
- ✅ Special Occasion Bus Management
- ✅ 38 District Coverage

## 📞 Support

For deployment issues, check:
1. **Troubleshooting** section in DEPLOYMENT_GUIDE.md  
2. Database comments in `database_setup.sql`
3. Verify XAMPP services are running

## 📦 What to Transfer

Copy the entire `smart-bus-portal` folder to the new system's `C:\xampp\htdocs\` directory.

---

**Version:** 1.0 | **Database Schema:** Complete | **Last Updated:** Feb 2026
