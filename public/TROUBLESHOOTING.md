# Language Translation Troubleshooting Guide

## Step 1: Check Current Language Setting

1. Open your browser
2. Navigate to: `http://localhost/smart-bus-portal/public/passenger_login.php`
3. Press **F12** to open Developer Tools
4. Click the **Console** tab
5. Type this command and press Enter:
   ```javascript
   localStorage.getItem('user_lang')
   ```
6. **What does it say?** (Should be 'ta' for Tamil, 'en' for English, 'hi' for Hindi)

## Step 2: Force Set Language to Tamil

In the same Console, type:
```javascript
localStorage.setItem('user_lang', 'ta')
```
Then refresh the page with **Ctrl + Shift + R**

## Step 3: Clear Browser Cache Completely

### For Chrome/Edge:
1. Press **Ctrl + Shift + Delete**
2. Select **Cached images and files**
3. Time range: **All time**
4. Click **Clear data**
5. Close browser completely
6. Reopen and try again

### For Firefox:
1. Press **Ctrl + Shift + Delete**
2. Select **Cache**
3. Time range: **Everything**
4. Click **OK**
5. Close browser completely
6. Reopen and try again

## Step 4: Test in Incognito/Private Window

1. Open **Incognito/Private** window
2. Go to: `http://localhost/smart-bus-portal/public/settings.php`
3. Select **Tamil (தமிழ்)**
4. Navigate to passenger login page
5. Check if buttons are in Tamil

## Step 5: Verify Apache is Running

1. Open XAMPP Control Panel
2. Check if **Apache** is running (should be green)
3. If not, click **Start**

## Step 6: Hard Refresh JavaScript Files

In the Console, type these commands one by one:
```javascript
// Check if translations are loaded
console.log(translations);

// Check if Tamil translations exist
console.log(translations.ta);

// Check specific keys
console.log(translations.ta.btn_sign_up);
console.log(translations.ta.btn_back_home);
```

Tell me what each of these outputs!

## Step 7: Check File Timestamp

Navigate to:
`c:\xampp\htdocs\smart-bus-portal\public\assets\JS\theme-manager.js`

Right-click → Properties → Check "Date modified"
It should be TODAY (2026-02-02)

If not, the file isn't being saved properly!
