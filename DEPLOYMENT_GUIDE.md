# Smart Bus Portal - Deployment Guide

## 📋 Prerequisites

Before deploying on a new system, ensure you have:

- **XAMPP** (or similar): Apache + MySQL + PHP 7.4+
- **Web Browser**: Chrome, Firefox, or Edge (latest version)
- **Git** (optional): For version control

## 📦 Files to Transfer

Transfer the **entire project folder** from your current system:

```
smart-bus-portal/
├── public/
│   ├── assets/
│   │   ├── CSS/
│   │   ├── js/
│   │   └── fonts/
│   ├── *.php (all PHP files)
│   └── *.html (all HTML files)
├── database_setup.sql (NEW - complete database setup)
└── DEPLOYMENT_GUIDE.md (this file)
```

## 🚀 Step-by-Step Deployment

### Step 1: Install XAMPP

1. Download XAMPP from [https://www.apachefriends.org](https://www.apachefriends.org)
2. Install XAMPP in `C:\xampp` (recommended)
3. Start **XAMPP Control Panel**

### Step 2: Copy Project Files

1. Copy the entire `smart-bus-portal` folder
2. Paste it into: `C:\xampp\htdocs\`
3. Final path should be: `C:\xampp\htdocs\smart-bus-portal\`

### Step 3: Set Up Database

#### Option A: Using phpMyAdmin (Recommended)

1. Start **Apache** and **MySQL** in XAMPP Control Panel
2. Open browser and go to: `http://localhost/phpmyadmin`
3. Click **"Import"** tab
4. Click **"Choose File"** and select: `C:\xampp\htdocs\smart-bus-portal\database_setup.sql`
5. Scroll down and click **"Import"**
6. Wait for success message: "Import has been successfully finished"

#### Option B: Using MySQL Command Line

1. Open Command Prompt
2. Navigate to XAMPP MySQL bin folder:
   ```cmd
   cd C:\xampp\mysql\bin
   ```
3. Run MySQL:
   ```cmd
   mysql -u root -p
   ```
4. When prompted for password, press **Enter** (default password is empty)
5. Import the SQL file:
   ```sql
   source C:/xampp/htdocs/smart-bus-portal/database_setup.sql
   ```
6. Exit MySQL:
   ```sql
   exit
   ```

### Step 4: Verify Database Configuration

1. Open: `C:\xampp\htdocs\smart-bus-portal\public\db.php`
2. Verify the database settings:
   ```php
   $servername = "localhost";     // ✓ Correct
   $username = "root";            // ✓ Correct for XAMPP
   $password = "";                // ✓ Correct for XAMPP (empty)
   $database = "smart_bus_portal"; // ✓ Must match
   ```
3. If everything matches, **no changes needed!**

### Step 5: Start the Application

1. **Start Services** in XAMPP Control Panel:
   - Click **Start** for Apache
   - Click **Start** for MySQL
   
2. **Access the Application**:
   - Open browser
   - Go to: `http://localhost/smart-bus-portal/public/index.php`

3. **You should see** the Smart Bus Portal homepage! 🎉

## 🧪 Testing the Deployment

### Test 1: Homepage
- URL: `http://localhost/smart-bus-portal/public/index.php`
- Should display: Welcome screen with Passenger/Staff portal options

### Test 2: Passenger Login
- Click **"Passenger Portal"**
- Try signing up with a mobile number
- Should work without errors

### Test 3: Staff Login
- Click **"Staff Portal"**
- Select **any district** (e.g., "Madurai")
- Username: `madurai_admin`
- Password: `admin`
- Should login successfully

### Test 4: Database Verification

Open phpMyAdmin (`http://localhost/phpmyadmin`) and check:

- ✅ Database `smart_bus_portal` exists
- ✅ Tables visible: `buses`, `attendance`, `platform_incharges`, `passengers`, `special_buses`, `feedback`
- ✅ Platform incharges table has **38 rows** (one for each district)

## 🔐 Security - IMPORTANT!

### Change Default Passwords (Production Only)

The database setup creates default accounts with password `"admin"` for all districts.

**For production deployment:**

1. Open phpMyAdmin
2. Select `smart_bus_portal` database
3. Click on `platform_incharges` table
4. Edit each record and change the `password` field
5. Use strong passwords like: `Admin@2026Secure!`

**For local development/testing:** You can keep the default passwords.

## 🎨 Theme & Language Settings

All theme colors and translations are already configured! Users can:

- Change themes: Go to Settings → Choose from 17 themes
- Change language: Go to Settings → Choose English/Tamil/Hindi

## 📊 Default Data Included

The database setup automatically creates:

- ✅ **38 Platform Incharge accounts** (one per Tamil Nadu district)
- ✅ **All required tables** with proper indexes
- ✅ **Database views** for optimized queries
- ✅ **Proper relationships** between tables

## ⚠️ Troubleshooting

### Problem: "Database connection failed"

**Solution:**
1. Check MySQL is running in XAMPP
2. Verify `db.php` has correct credentials
3. Ensure database name is `smart_bus_portal`

### Problem: "Table doesn't exist"

**Solution:**
1. Re-import `database_setup.sql` using phpMyAdmin
2. Check that import completed successfully
3. Refresh phpMyAdmin to see tables

### Problem: "Page not found" (404 Error)

**Solution:**
1. Check project is in: `C:\xampp\htdocs\smart-bus-portal\`
2. Use correct URL: `http://localhost/smart-bus-portal/public/index.php`
3. Check Apache is running in XAMPP

### Problem: "Theme colors not working"

**Solution:**
1. Clear browser cache: `Ctrl + Shift + Delete`
2. Hard refresh: `Ctrl + Shift + R`
3. Check file exists: `public/assets/js/theme-manager.js`

### Problem: "Cannot login to staff portal"

**Solution:**
1. Username format: `district_admin` (e.g., `chennai_admin`, `madurai_admin`)
2. Password: `admin` (default)
3. Select correct district first before logging in

## 📁 Directory Structure

```
C:\xampp\htdocs\smart-bus-portal\
│
├── public/                          # Main application folder
│   ├── index.php                    # Homepage
│   ├── db.php                       # Database connection
│   │
│   ├── passenger_login.php          # Passenger login/signup
│   ├── passenger_dashboard.php      # Passenger dashboard
│   ├── bus_details.php              # Bus details page
│   ├── bus_chat_bot.php             # AI chatbot
│   │
│   ├── staff_district_selection.php # Staff district selection
│   ├── staff_login.php              # Staff login
│   ├── platform_dashboard.php       # Staff dashboard
│   ├── add_bus.php                  # Add new bus
│   ├── delete_bus.php               # Delete bus
│   ├── mark_attendance.php          # Mark attendance
│   ├── special_bus.php              # Special occasion buses
│   │
│   ├── about.php                    # About page
│   ├── community.php                # Community page
│   ├── creator.php                  # Creator page
│   ├── feedback.php                 # Feedback page
│   ├── settings.php                 # Settings page
│   │
│   └── assets/
│       ├── CSS/
│       │   └── custom_style.css     # Main stylesheet
│       ├── js/
│       │   ├── theme-manager.js     # Theme system (17 themes)
│       │   ├── font-color-loader.js # Font color handler
│       │   └── page-transitions.js  # Page transitions
│       └── fonts/                   # Custom fonts
│
├── database_setup.sql               # Complete database setup
└── DEPLOYMENT_GUIDE.md              # This file
```

## 🎯 Quick Start Checklist

- [ ] XAMPP installed
- [ ] Project folder copied to `C:\xampp\htdocs\`
- [ ] Apache started in XAMPP
- [ ] MySQL started in XAMPP
- [ ] Database imported via phpMyAdmin
- [ ] Opened `http://localhost/smart-bus-portal/public/index.php`
- [ ] Tested passenger signup
- [ ] Tested staff login
- [ ] Application working correctly! ✅

## 📞 Database Details

- **Database Name:** `smart_bus_portal`
- **Total Tables:** 6
- **Character Set:** utf8mb4 (supports all languages including Tamil, Hindi)
- **Timezone:** Asia/Kolkata (IST +05:30)
- **Default Username:** root
- **Default Password:** (empty)

## 🌟 Features Ready to Use

✅ **Multi-language support** - English, Tamil, Hindi  
✅ **17 premium themes** - Professional color schemes  
✅ **Real-time bus tracking** - Attendance & status updates  
✅ **AI Chatbot** - Bus search assistant  
✅ **Special occasion buses** - Festival & event services  
✅ **38 districts** - Complete Tamil Nadu coverage  
✅ **Responsive design** - Works on all devices  

## 🎉 Deployment Complete!

Your Smart Bus Portal is now ready to use on the new system!

**Need help?** Check the troubleshooting section above or review the SQL file comments for database details.

---

**Version:** 1.0  
**Last Updated:** February 2026  
**Database Schema:** Complete with all tables, views, and initial data
