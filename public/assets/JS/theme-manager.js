/**
 * Global Theme and Language Manager
 * Handles applying styles and translations across the Smart Bus Portal
 */

const themes = {
    // Professional & Premium Themes
    executive: {
        '--primary-blue': '#d4af37',
        '--gradient-primary': 'linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #2d2d2d 100%)',
        'bg': 'linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%)',
        '--text-main': '#ffffff',
        '--text-heading': '#ffd700',
        '--text-shadow-glow': '0 0 10px rgba(212, 175, 55, 0.4)',
        '--card-bg': 'rgba(20, 20, 20, 0.95)',
        '--input-bg': '#1a1a1a',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(212, 175, 55, 0.3)'
    },
    corporate: {
        '--primary-blue': '#3b82f6',
        '--gradient-primary': 'linear-gradient(135deg, #0a1e3d 0%, #1e3a5f 50%, #2563eb 100%)',
        'bg': '#0a1e3d',
        '--text-main': '#ffffff',
        '--text-heading': '#60a5fa',
        '--text-shadow-glow': '0 0 10px rgba(59, 130, 246, 0.3)',
        '--card-bg': 'rgba(15, 23, 42, 0.95)',
        '--input-bg': '#1e293b',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(59, 130, 246, 0.2)'
    },
    emerald: {
        '--primary-blue': '#10b981',
        '--gradient-primary': 'linear-gradient(135deg, #022c22 0%, #064e3b 50%, #065f46 100%)',
        'bg': '#022c22',
        '--text-main': '#ffffff',
        '--text-heading': '#34d399',
        '--text-shadow-glow': '0 0 10px rgba(16, 185, 129, 0.3)',
        '--card-bg': 'rgba(6, 78, 59, 0.95)',
        '--input-bg': '#065f46',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(16, 185, 129, 0.2)'
    },
    slate: {
        '--primary-blue': '#94a3b8',
        '--gradient-primary': 'linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%)',
        'bg': '#1e293b',
        '--text-main': '#ffffff',
        '--text-heading': '#e2e8f0',
        '--text-shadow-glow': '0 0 10px rgba(148, 163, 184, 0.2)',
        '--card-bg': 'rgba(15, 23, 42, 0.95)',
        '--input-bg': '#1e293b',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(148, 163, 184, 0.2)'
    },
    platinum: {
        '--primary-blue': '#e4e4e7',
        '--gradient-primary': 'linear-gradient(135deg, #18181b 0%, #27272a 50%, #3f3f46 100%)',
        'bg': '#18181b',
        '--text-main': '#ffffff',
        '--text-heading': '#f4f4f5',
        '--text-shadow-glow': '0 0 15px rgba(255, 255, 255, 0.2)',
        '--card-bg': 'rgba(24, 24, 27, 0.95)',
        '--input-bg': '#27272a',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(228, 228, 231, 0.2)'
    },
    sapphire: {
        '--primary-blue': '#3b82f6',
        '--gradient-primary': 'linear-gradient(135deg, #172554 0%, #1e3a8a 50%, #1e40af 100%)',
        'bg': '#172554',
        '--text-main': '#ffffff',
        '--text-heading': '#60a5fa',
        '--text-shadow-glow': '0 0 10px rgba(59, 130, 246, 0.3)',
        '--card-bg': 'rgba(30, 58, 138, 0.95)',
        '--input-bg': '#1e3a8a',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(59, 130, 246, 0.2)'
    },
    crimson: {
        '--primary-blue': '#ef4444',
        '--gradient-primary': 'linear-gradient(135deg, #450a0a 0%, #7f1d1d 50%, #991b1b 100%)',
        'bg': '#450a0a',
        '--text-main': '#ffffff',
        '--text-heading': '#f87171',
        '--text-shadow-glow': '0 0 10px rgba(239, 68, 68, 0.3)',
        '--card-bg': 'rgba(127, 29, 29, 0.95)',
        '--input-bg': '#991b1b',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(239, 68, 68, 0.2)'
    },
    onyx: {
        '--primary-blue': '#ffffff',
        '--gradient-primary': 'linear-gradient(135deg, #000000 0%, #0a0a0a 50%, #171717 100%)',
        'bg': '#000000',
        '--text-main': '#ffffff',
        '--text-heading': '#ffffff',
        '--text-shadow-glow': '0 0 15px rgba(255, 255, 255, 0.4)',
        '--card-bg': 'rgba(10, 10, 10, 0.95)',
        '--input-bg': '#171717',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(255, 255, 255, 0.1)'
    },
    amber: {
        '--primary-blue': '#fbbf24',
        '--gradient-primary': 'linear-gradient(135deg, #451a03 0%, #78350f 50%, #92400e 100%)',
        'bg': '#451a03',
        '--text-main': '#ffffff',
        '--text-heading': '#fbbf24',
        '--text-shadow-glow': '0 0 10px rgba(251, 191, 36, 0.3)',
        '--card-bg': 'rgba(120, 53, 15, 0.95)',
        '--input-bg': '#92400e',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(251, 191, 36, 0.2)'
    },
    arctic: {
        '--primary-blue': '#22d3ee',
        '--gradient-primary': 'linear-gradient(135deg, #083344 0%, #164e63 50%, #155e75 100%)',
        'bg': '#083344',
        '--text-main': '#ffffff',
        '--text-heading': '#06b6d4',
        '--text-shadow-glow': '0 0 10px rgba(34, 211, 238, 0.3)',
        '--card-bg': 'rgba(21, 94, 117, 0.95)',
        '--input-bg': '#155e75',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(34, 211, 238, 0.2)'
    },

    // Original Themes
    dark: {
        '--primary-blue': '#38bdf8',
        '--gradient-primary': 'linear-gradient(135deg, #0f172a 0%, #1e293b 100%)',
        'bg': '#0f172a',
        '--text-main': '#ffffff',
        '--text-heading': '#0ea5e9',
        '--text-shadow-glow': '0 0 10px rgba(56, 189, 248, 0.2)',
        '--card-bg': 'rgba(30, 41, 59, 0.95)',
        '--input-bg': '#1e293b',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(56, 189, 248, 0.1)'
    },
    midnight: {
        '--primary-blue': '#818cf8',
        '--gradient-primary': 'linear-gradient(135deg, #1e1b4b 0%, #312e81 100%)',
        'bg': '#1e1b4b',
        '--text-main': '#ffffff',
        '--text-heading': '#818cf8',
        '--text-shadow-glow': '0 0 10px rgba(129, 140, 248, 0.3)',
        '--card-bg': 'rgba(49, 46, 129, 0.95)',
        '--input-bg': '#312e81',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(129, 140, 248, 0.2)'
    },
    ocean: {
        '--primary-blue': '#38bdf8',
        '--gradient-primary': 'linear-gradient(135deg, #0c4a6e 0%, #0284c7 100%)',
        'bg': '#0c4a6e',
        '--text-main': '#ffffff',
        '--text-heading': '#0ea5e9',
        '--text-shadow-glow': '0 0 10px rgba(56, 189, 248, 0.3)',
        '--card-bg': 'rgba(2, 132, 199, 0.95)',
        '--input-bg': '#075985',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(56, 189, 248, 0.2)'
    },
    sunset: {
        '--primary-blue': '#fbbf24',
        '--gradient-primary': 'linear-gradient(135deg, #7c2d12 0%, #f97316 100%)',
        'bg': '#7c2d12',
        '--text-main': '#ffffff',
        '--text-heading': '#fb923c',
        '--text-shadow-glow': '0 0 10px rgba(251, 191, 36, 0.3)',
        '--card-bg': 'rgba(124, 45, 18, 0.95)',
        '--input-bg': '#9a3412',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(251, 191, 36, 0.2)'
    },
    forest: {
        '--primary-blue': '#34d399',
        '--gradient-primary': 'linear-gradient(135deg, #064e3b 0%, #10b981 100%)',
        'bg': '#064e3b',
        '--text-main': '#ffffff',
        '--text-heading': '#10b981',
        '--text-shadow-glow': '0 0 10px rgba(52, 211, 153, 0.3)',
        '--card-bg': 'rgba(6, 78, 59, 0.95)',
        '--input-bg': '#065f46',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(52, 211, 153, 0.2)'
    },
    royal: {
        '--primary-blue': '#a78bfa',
        '--gradient-primary': 'linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%)',
        'bg': '#4c1d95',
        '--text-main': '#ffffff',
        '--text-heading': '#a78bfa',
        '--text-shadow-glow': '0 0 10px rgba(167, 139, 250, 0.3)',
        '--card-bg': 'rgba(76, 29, 149, 0.95)',
        '--input-bg': '#5b21b6',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(167, 139, 250, 0.2)'
    },
    berry: {
        '--primary-blue': '#f472b6',
        '--gradient-primary': 'linear-gradient(135deg, #831843 0%, #db2777 100%)',
        'bg': '#831843',
        '--text-main': '#ffffff',
        '--text-heading': '#ec4899',
        '--text-shadow-glow': '0 0 10px rgba(244, 114, 182, 0.3)',
        '--card-bg': 'rgba(131, 24, 67, 0.95)',
        '--input-bg': '#9d174d',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(244, 114, 182, 0.2)'
    },
    graphite: {
        '--primary-blue': '#a1a1aa',
        '--gradient-primary': 'linear-gradient(135deg, #18181b 0%, #27272a 100%)',
        'bg': '#18181b',
        '--text-main': '#ffffff',
        '--text-heading': '#e4e4e7',
        '--text-shadow-glow': '0 0 10px rgba(161, 161, 170, 0.2)',
        '--card-bg': 'rgba(39, 39, 42, 0.95)',
        '--input-bg': '#18181b',
        '--input-text': '#ffffff',
        '--border-color': 'rgba(161, 161, 170, 0.2)'
    }
};

const translations = {
    en: {
        app_title: "Smart Bus Portal",
        app_subtitle: "Real-time Bus Tracking & Attendance Management",
        pass_portal: "Passenger Portal",
        staff_portal: "Staff Portal",

        // Navigation / Common
        nav_about: "About Us",
        nav_community: "Community",
        nav_creator: "Creator",
        nav_feedback: "Feedback",
        nav_settings: "Settings",

        // About Page
        about_title: "About Us",
        about_p1: "Welcome to the <strong>Smart Bus Portal</strong>. This platform is designed to revolutionize public transportation management in Tamil Nadu through real-time tracking and automated attendance systems.",
        about_p2: "Our mission is to provide safe, reliable, and efficient transport solutions for passengers and staff alike, ensuring a seamless travel experience for everyone.",

        // Community Page
        comm_title: "Community",
        comm_desc: "Join our growing community of developers and transport enthusiasts!",

        // Creator Page
        creator_title: "Creator",
        creator_heading: "Developed with ❤️ by the Tech Team",
        creator_desc: "Dedicated to building smart solutions for a better tomorrow.",
        creator_footer: "Version 1.0.0 • © 2026 Smart Bus Portal",

        // Feedback Page
        feed_title: "Feedback",
        feed_desc: "We value your thoughts! Let us know how we can improve.",
        feed_name_lbl: "Your Name (Optional)",
        feed_msg_lbl: "Your Message",
        feed_btn: "Submit Feedback",
        feed_placeholder: "Tell us what you think...",

        // Settings Page
        set_title: "Settings",
        set_lang: "Language",
        set_theme: "Interface Theme",

        // Passenger Login
        pass_login_title: "Passenger Login",
        pass_login_desc: "Access your journey details",
        lbl_email: "Email Address",
        lbl_password: "Password",
        btn_sign_in: "Sign In",

        // Staff District Selection
        dist_select_title: "Select Your District",
        dist_select_desc: "Choose the district you are responsible for",
        btn_back_home: "Back to Home",

        // Staff Login
        staff_login_title: "Staff Login",
        lbl_username: "Username",
        btn_login: "Login",
        btn_back_districts: "Back to Districts",

        // Dashboards Common
        btn_logout: "Logout",
        dash_passenger_title: "Passenger Dashboard",
        dash_staff_title: "Bus Schedule Management",

        // Passenger Dashboard
        select_bus_type: "Select Bus Type",
        change_district: "Change District",
        setc_title: "SETC",
        setc_desc: "State Express Transport",
        ptp_title: "Point-To-Point",
        ptp_desc: "Direct Route Service",
        route_bus_title: "Route Bus",
        route_bus_desc: "Multiple Stop Service",
        view_buses: "View Buses",
        shift_label: "Shift",
        shift_timings: "Shift Timings",
        route_stops: "Route Stops",

        // Table Headers
        th_bus_id: "Bus ID",
        th_route: "Route",
        th_dept_time: "Departure Time",
        th_arr_time: "Arrival Time",
        th_status: "Status",
        th_action: "Update Status",

        // Add Bus
        add_bus_title: "Add Bus",
        sel_bus_cat: "Select Bus Category",

        // Bus Details
        bus_det_title: "Bus Details",
        shift_timings: "Shift Timings",
        route_stops: "Route Stops",

        // Mark Attendance
        mark_att_title: "Mark Attendance",
        sel_cat: "Select a category to proceed",
        att_sheet: "Attendance Sheet",
        save_records: "Save All Records",
        view_logs: "Today's Logs",

        // Platform Dashboard Cards
        card_add_bus: "Add Bus",
        card_del_bus: "Delete Bus",
        card_view_bus: "View Buses",
        card_mark_att: "Mark Attendance",
        btn_add: "Add",
        btn_del: "Delete",
        btn_view: "View",
        btn_mark: "Mark"
    },
    ta: {
        app_title: "ஸ்மார்ட் பஸ் போர்டல்",
        app_subtitle: "நிகழ்நேர பேருந்து கண்காணிப்பு & வருகை மேலாண்மை",
        pass_portal: "பயணிகள் தளம்",
        staff_portal: "ஊழியர் தளம்",

        nav_about: "எங்களை பற்றி",
        nav_community: "சமூகம்",
        nav_creator: "உருவாக்கியவர்",
        nav_feedback: "கருத்து",
        nav_settings: "அமைப்புகள்",

        about_title: "எங்களை பற்றி",
        about_p1: "<strong>ஸ்மார்ட் பஸ் போர்டலுக்கு</strong> வரவேற்கிறோம். இந்த தளம் தமிழ்நாட்டில் பொது போக்குவரத்து மேலாண்மையில் புரட்சியை ஏற்படுத்த நிகழ்நேர கண்காணிப்பு மற்றும் தானியங்கி வருகை அமைப்புகள் மூலம் வடிவமைக்கப்பட்டுள்ளது.",
        about_p2: "பயணிகள் மற்றும் ஊழியர்களுக்கு பாதுகாப்பான, நம்பகமான மற்றும் திறமையான போக்குவரத்து தீர்வுகளை வழங்குவதே எங்கள் நோக்கம்.",

        comm_title: "சமூகம்",
        comm_desc: "எங்கள் வளர்ந்து வரும் டெவலப்பர்கள் மற்றும் போக்குவரத்து ஆர்வலர்கள் சமூகத்தில் இணையுங்கள்!",

        creator_title: "உருவாக்கியவர்",
        creator_heading: "தொழில்நுட்ப குழுவால் ❤️ உடன் உருவாக்கப்பட்டது",
        creator_desc: "சிறந்த எதிர்காலத்திற்கான ஸ்மார்ட் தீர்வுகளை உருவாக்குவதில் அர்ப்பணிப்பு.",
        creator_footer: "பதிப்பு 1.0.0 • © 2026 ஸ்மார்ட் பஸ் போர்டல்",

        feed_title: "கருத்து",
        feed_desc: "உங்கள் கருத்துக்களை நாங்கள் மதிக்கிறோம்! நாங்கள் எவ்வாறு மேம்படுத்தலாம் என்பதை எங்களுக்குத் தெரியப்படுத்துங்கள்.",
        feed_name_lbl: "உங்கள் பெயர் (விருப்பினால்)",
        feed_msg_lbl: "உங்கள் செய்தி",
        feed_btn: "கருத்தை சமர்ப்பிக்கவும்",
        feed_placeholder: "உங்கள் கருத்துக்களை இங்கே பகிரவும்...",

        set_title: "அமைப்புகள்",
        set_lang: "மொழி",
        set_theme: "காட்சி தீம்",

        // Passenger Login
        pass_login_title: "பயணிகள் உள்நுழைவு",
        pass_login_desc: "உங்கள் பயண விவரங்களை அணுகவும்",
        lbl_email: "மின்னஞ்சல் முகவரி",
        lbl_password: "கடவுச்சொல்",
        btn_sign_in: "உள்நுழைய",

        // Staff District Selection
        dist_select_title: "உங்கள் மாவட்டத்தைத் தேர்ந்தெடுக்கவும்",
        dist_select_desc: "நீங்கள் பொறுப்பான மாவட்டத்தைத் தேர்வுசெய்க",
        btn_back_home: "முகப்புக்குத் திரும்பு",

        // Staff Login
        staff_login_title: "ஊழியர் உள்நுழைவு",
        lbl_username: "பயனர் பெயர்",
        btn_login: "உள்நுழைய",
        btn_back_districts: "மாவட்டங்களுக்குத் திரும்பு",

        // Dashboards Common
        btn_logout: "வெளியேறு",
        dash_passenger_title: "பயணிகள் களம்",
        dash_staff_title: "பேருந்து அட்டவணை மேலாண்மை",

        // Passenger Dashboard
        select_bus_type: "பேருந்து வகையைத் தேர்ந்தெடுக்கவும்",
        change_district: "மாவட்டத்தை மாற்றவும்",
        setc_title: "எஸ்.இ.டி.சி",
        setc_desc: "மாநில விரைவு போக்குவரத்து",
        ptp_title: "புள்ளி-க்கு-புள்ளி",
        ptp_desc: "நேரடி வழித்தடம்",
        route_bus_title: "வழித்தட பேருந்து",
        route_bus_desc: "பல நிறுத்த சேவை",
        view_buses: "பேருந்துகளை பார்க்கவும்",
        shift_label: "மாற்றம்",
        shift_timings: "மாற்ற நேரங்கள்",
        route_stops: "தட நிலுத்தங்கள்",

        // Table Headers
        th_bus_id: "பேருந்து எண்",
        th_route: "தடம்",
        th_dept_time: "புறப்படும் நேரம்",
        th_arr_time: "வரும் நேரம்",
        th_status: "நிலை",
        th_action: "நிலையை புதுப்பிக்கவும்",

        // Add Bus
        add_bus_title: "பேருந்து சேர்க்க",
        sel_bus_cat: "பேருந்து வகையைத் தேர்ந்தெடுக்கவும்",

        // Bus Details
        bus_det_title: "பேருந்து விவரங்கள்",
        shift_timings: "மாற்ற நேரங்கள்",
        route_stops: "தடம் நிறுத்தங்கள்",

        // Mark Attendance
        mark_att_title: "வருகையைப் பதிவு செய்க",
        sel_cat: "தொடர ஒரு வகையைத் தேர்ந்தெடுக்கவும்",
        att_sheet: "வருகை தாள்",
        save_records: "அனைத்து பதிவுகளையும் சேமிக்கவும்",
        view_logs: "இன்றைய பதிவுகள்",

        // Platform Dashboard Cards
        card_add_bus: "பேருந்து சேர்க்க",
        card_del_bus: "பேருந்து நீக்க",
        card_view_bus: "பேருந்துகளைப் பார்க்க",
        card_mark_att: "வருகையைப் பதிவு செய்க",
        btn_add: "சேர்",
        btn_del: "நீக்கு",
        btn_view: "பார்",
        btn_mark: "பதிவு"
    },
    hi: {
        app_title: "स्मार्ट बस पोर्टल",
        app_subtitle: "वास्तविक समय बस ट्रैकिंग और उपस्थिति प्रबंधन",
        pass_portal: "यात्री पोर्टल",
        staff_portal: "कर्मचारी पोर्टल",

        nav_about: "हमारे बारे में",
        nav_community: "समुदाय",
        nav_creator: "निर्माता",
        nav_feedback: "सुझाव",
        nav_settings: "सेटिंग्स",

        about_title: "हमारे बारे में",
        about_p1: "<strong>स्मार्ट बस पोर्टल</strong> में आपका स्वागत है। यह मंच रीयल-टाइम ट्रैकिंग और स्वचालित उपस्थिति प्रणाली के माध्यम से तमिलनाडु में सार्वजनिक परिवहन प्रबंधन में क्रांति लाने के लिए डिज़ाइन किया गया है।",
        about_p2: "हमारा मिशन यात्रियों और कर्मचारियों के लिए सुरक्षित, विश्वसनीय और कुशल परिवहन समाधान प्रदान करना है।",

        comm_title: "समुदाय",
        comm_desc: "डेवलपर्स और परिवहन उत्साही लोगों के हमारे बढ़ते समुदाय में शामिल हों!",

        creator_title: "निर्माता",
        creator_heading: "टेक टीम द्वारा ❤️ के साथ विकसित",
        creator_desc: "बेहतर कल के लिए स्मार्ट समाधान बनाने के लिए समर्पित।",
        creator_footer: "संस्करण 1.0.0 • © 2026 स्मार्ट बस पोर्टल",

        feed_title: "सुझाव",
        feed_desc: "हम आपके विचारों को महत्व देते हैं! हमें बताएं कि हम कैसे सुधार कर सकते हैं।",
        feed_name_lbl: "आपका नाम (वैकल्पिक)",
        feed_msg_lbl: "आपका संदेश",
        feed_btn: "सुझाव जमा करें",
        feed_placeholder: "अपने विचार हमारे साथ साझा करें...",

        set_title: "सेटिंग्स",
        set_lang: "भाषा",
        set_theme: "दृश्य थीम",

        // Passenger Login
        pass_login_title: "यात्री लॉगिन",
        pass_login_desc: "अपनी यात्रा विवरण तक पहुंचें",
        lbl_email: "ईमेल पता",
        lbl_password: "पासवर्ड",
        btn_sign_in: "साइन इन करें",

        // Staff District Selection
        dist_select_title: "अपना जिला चुनें",
        dist_select_desc: "वह जिला चुनें जिसके लिए आप जिम्मेदार हैं",
        btn_back_home: "मुख्य पृष्ठ पर वापस",

        // Staff Login
        staff_login_title: "कर्मचारी लॉगिन",
        lbl_username: "उपयोगकर्ता नाम",
        btn_login: "लॉग इन करें",
        btn_back_districts: "जिलों पर वापस जाएं",

        // Dashboards Common
        btn_logout: "लॉग आउट",
        dash_passenger_title: "यात्री डैशबोर्ड",
        dash_staff_title: "बस अनुसूची प्रबंधन",

        // Passenger Dashboard
        select_bus_type: "बस प्रकार चुनें",
        change_district: "जिला बदलें",
        setc_title: "एस.ई.टी.सी",
        setc_desc: "राज्य एक्सप्रेस परिवहन",
        ptp_title: "बिंदु-से-बिंदु",
        ptp_desc: "सीधी मार्ग सेवा",
        route_bus_title: "मार्ग बस",
        route_bus_desc: "कई स्टॉप सेवा",
        view_buses: "बसें देखें",
        shift_label: "शिफ्ट",
        shift_timings: "शिफ्ट समय",
        route_stops: "मार्ग स्टॉप",

        // Table Headers
        th_bus_id: "बस आईडी",
        th_route: "मार्ग",
        th_dept_time: "प्रस्थान समय",
        th_arr_time: "आगमन समय",
        th_status: "स्थिति",
        th_action: "स्थिति अपडेट करें",

        // Add Bus
        add_bus_title: "बस जोड़ें",
        sel_bus_cat: "बस श्रेणी चुनें",

        // Bus Details
        bus_det_title: "बस विवरण",
        shift_timings: "शिफ्ट समय",
        route_stops: "मार्ग स्टॉप",

        // Mark Attendance
        mark_att_title: "उपस्थिति दर्ज करें",
        sel_cat: "आगे बढ़ने के लिए एक श्रेणी चुनें",
        att_sheet: "उपस्थिति पत्रक",
        save_records: "सभी रिकॉर्ड सहेजें",
        view_logs: "आज के लॉग",

        // Platform Dashboard Cards
        card_add_bus: "बस जोड़ें",
        card_del_bus: "बस हटाएं",
        card_view_bus: "बसें देखें",
        card_mark_att: "उपस्थिति दर्ज करें",
        btn_add: "जोड़ें",
        btn_del: "हटाना",
        btn_view: "देखें",
        btn_mark: "चिह्नित"
    }
};

function applyTheme(themeName) {
    if (!themeName) return;
    localStorage.setItem('user_theme', themeName);

    const theme = themes[themeName] || themes.dark;
    const root = document.documentElement;

    // Apply CSS variables
    for (const [key, value] of Object.entries(theme)) {
        if (key !== 'bg') root.style.setProperty(key, value);
    }
    document.body.style.background = theme.bg || '';

    // Add theme class to body for special styling
    document.body.className = document.body.className.replace(/theme-\w+/g, '');
    document.body.classList.add('theme-' + themeName);

    // Update active state in Settings UI if present
    const cards = document.querySelectorAll('.theme-card');
    cards.forEach(card => {
        card.classList.toggle('active', card.getAttribute('data-theme-id') === themeName);
    });
}

function applyLanguage(lang) {
    if (!lang) return;
    localStorage.setItem('user_lang', lang);

    const t = translations[lang];
    if (!t) return;

    // Apply translations to elements with matching ID in the dictionary keys
    // We map generic IDs to dictionary keys

    // Index Page
    updateText('nav_about', t.nav_about);
    updateText('nav_community', t.nav_community);
    updateText('nav_creator', t.nav_creator);
    updateText('nav_feedback', t.nav_feedback);
    updateText('nav_settings', t.nav_settings);

    // Special handling for HTML content in title/about
    const titleEl = document.querySelector('.portal-title');
    if (titleEl) titleEl.innerHTML = `<i class="bi bi-bus-front me-3"></i>${t.app_title}`;

    updateText('feature_subtitle', t.app_subtitle);
    updateText('lbl_passenger', t.pass_portal);
    updateText('lbl_staff', t.staff_portal);

    // Sub-pages
    updateText('page_title', () => {
        // Context-aware title update
        if (window.location.href.includes('about')) return t.about_title;
        if (window.location.href.includes('community')) return t.comm_title;
        if (window.location.href.includes('creator')) return t.creator_title;
        if (window.location.href.includes('feedback')) return t.feed_title;
        if (window.location.href.includes('settings')) return t.set_title;
        // Check for other pages
        if (window.location.href.includes('add_bus')) return t.add_bus_title;
        if (window.location.href.includes('mark_attendance')) return t.mark_att_title;
        return null;
    });

    // Content specific
    const aboutContent = document.getElementById('about_content');
    if (aboutContent) {
        aboutContent.innerHTML = `<p>${t.about_p1}</p><p>${t.about_p2}</p>`;
    }

    updateText('comm_desc', t.comm_desc);

    updateText('creator_heading', t.creator_heading);
    updateText('creator_desc', t.creator_desc);
    updateText('creator_footer', t.creator_footer);

    updateText('feed_desc', t.feed_desc);
    updateText('lbl_name', t.feed_name_lbl);
    updateText('lbl_msg', t.feed_msg_lbl);
    updateText('btn_submit', t.feed_btn);
    const feedInput = document.getElementById('msg_input');
    if (feedInput) feedInput.placeholder = t.feed_placeholder;

    // Settings Page Buttons
    updateText('lbl_lang_section', t.set_lang);
    updateText('lbl_theme_section', t.set_theme);

    // Passenger Login
    updateText('lbl_login_title', t.passenger_login_title);
    updateText('lbl_login_desc', t.passenger_login_desc);
    updateText('lbl_email', t.lbl_email);
    updateText('lbl_pass', t.lbl_password); // kept for other pages if needed
    updateText('lbl_mobile', t.mobile_number_label);
    updateText('lbl_name', t.passenger_name_label); // Reused from feedback or generic
    updateText('lbl_security_check', t.security_check_label);
    updateText('lbl_admin_prompt', t.admin_prompt);
    updateText('lnk_staff_login', t.staff_login);
    updateText('btn_back', t.btn_back_home); // This was already present for dist_select, now also for passenger login
    updateText('btn_back_dist', t.back_to_districts); // This was already present for staff login, now also for passenger login

    // Dynamic Placeholders
    const mobileInput = document.getElementById('mobileNumberInput');
    if (mobileInput) mobileInput.placeholder = t.mobile_number_placeholder || "Enter 10-digit number";

    const passengerInput = document.getElementById('passengerNameInput');
    if (passengerInput) passengerInput.placeholder = t.passenger_name_placeholder || "Enter your Name";

    const captchaInput = document.getElementById('captchaInput');
    if (captchaInput) captchaInput.placeholder = t.captcha_placeholder || "Enter code";

    const btnRefresh = document.getElementById('btn_refresh_captcha');
    if (btnRefresh) btnRefresh.innerHTML = '<i class="bi bi-arrow-clockwise"></i> ' + (t.refresh_captcha_btn || "Refresh");

    // Error Messages (if present)
    updateText('err_captcha', t.err_captcha);
    updateText('err_mobile', t.err_mobile);
    updateText('err_user_not_found', t.err_user_not_found);
    updateText('err_user_exists', t.err_user_exists);

    updateText('btn_sign_in', t.btn_sign_in);

    // Passenger Login Tab Buttons and Form Titles
    updateText('btnSigninTab', t.btn_sign_in);
    updateText('btnSignupTab', t.btn_sign_up);
    updateText('formTitle', () => {
        const actionInput = document.getElementById('actionInput');
        if (actionInput && actionInput.value === 'signup') {
            return t.create_acc;
        }
        return t.welcome_back;
    });
    updateText('formSubtitle', () => {
        const actionInput = document.getElementById('actionInput');
        if (actionInput && actionInput.value === 'signup') {
            return t.join_now;
        }
        return t.signin_desc;
    });

    // Submit Button - handle both signin and signup modes
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        const actionInput = document.getElementById('actionInput');
        if (actionInput && actionInput.value === 'signup') {
            submitBtn.innerHTML = (t.btn_sign_up || "Sign Up") + ' <i class="bi bi-arrow-right ms-2"></i>';
        } else {
            submitBtn.innerHTML = (t.btn_sign_in || "Sign In") + ' <i class="bi bi-arrow-right ms-2"></i>';
        }
    }

    // Staff District Select
    updateText('dist_title', t.dist_select_title);
    updateText('dist_desc', t.dist_select_desc);
    // updateText('btn_back', t.btn_back_home); // Already handled above for passenger login, which is fine as it's a generic back button

    // Staff Login
    updateText('staff_login_title', t.staff_login_title);
    updateText('lbl_username', t.lbl_username);
    updateText('btn_login', t.btn_login);
    updateText('btn_back_dist', t.btn_back_districts);

    // Dashboards
    updateText('btn_logout', t.btn_logout);
    updateText('dash_passenger_title', t.dash_passenger_title);
    updateText('dash_staff_title', t.dash_staff_title);

    // Passenger Dashboard
    updateText('select_bus_type', t.select_bus_type);
    updateText('change_district', t.change_district);
    updateText('setc_title', t.setc_title);
    updateText('setc_desc', t.setc_desc);
    updateText('ptp_title', t.ptp_title);
    updateText('ptp_desc', t.ptp_desc);
    updateText('route_bus_title', t.route_bus_title);
    updateText('route_bus_desc', t.route_bus_desc);
    updateText('view_buses_1', t.view_buses);
    updateText('view_buses_2', t.view_buses);
    updateText('view_buses_3', t.view_buses);

    updateText('dash_passenger_title', t.dash_passenger_title);
    updateText('dash_staff_title', t.dash_staff_title);

    // Functional Pages
    updateText('sel_bus_cat', t.sel_bus_cat);
    updateText('bus_det_title', t.bus_det_title);
    updateText('lbl_shift_timings', t.shift_timings);
    updateText('shift_timings_text', t.shift_timings);
    updateText('lbl_route_stops', t.route_stops);
    updateText('route_stops_text', t.route_stops);
    updateText('lbl_sel_cat', t.sel_cat);
    updateText('lbl_att_sheet', t.att_sheet);
    updateText('btn_save_records', t.save_records);
    updateText('lbl_logs', t.view_logs);

    // Platform Dashboard
    updateText('card_add_bus', t.card_add_bus);
    updateText('card_del_bus', t.card_del_bus);
    updateText('card_view_bus', t.card_view_bus);
    updateText('card_mark_att', t.card_mark_att);
    updateText('btn_add', t.btn_add);
    updateText('btn_del', t.btn_del);
    updateText('btn_view', t.btn_view);
    updateText('btn_mark', t.btn_mark);

    // Tables (Using class query selector for multiple headers if needed,
    // or IDs if implemented simply. For now, let's assume specific IDs or single table)
    updateText('th_bus_id', t.th_bus_id);
    updateText('th_route', t.th_route);
    updateText('th_dept_time', t.th_dept_time);
    updateText('th_arr_time', t.th_arr_time);
    updateText('th_status', t.th_status);
    updateText('th_action', t.th_action);

    // Expose current translations for dynamic JS usage
    window.currentTranslations = t;

    // Translate dynamic district attributes
    if (translations[lang].districts) {
        document.querySelectorAll('[data-translate-district]').forEach(el => {
            const key = el.getAttribute('data-translate-district');
            if (translations[lang].districts[key]) {
                el.innerText = translations[lang].districts[key];
            }
        });
    }

    // Trigger custom event for pages to update dynamic content
    window.dispatchEvent(new CustomEvent('languageChanged', { detail: { lang: lang, t: t } }));

    // Update Active Language Button State globally
    ['en', 'ta', 'hi'].forEach(l => {
        const btn = document.getElementById(`btn_lang_${l}`);
        if (btn) {
            btn.classList.toggle('active', l === lang);
        }
    });
}

// Add District Translations to the dictionary
const districtData = {
    ariyalur: { en: "Ariyalur", ta: "அரியலூர்", hi: "अरियलूर" },
    chengalpattu: { en: "Chengalpattu", ta: "செங்கல்பட்டு", hi: "चेंगलपट्टू" },
    chennai: { en: "Chennai", ta: "சென்னை", hi: "चेन्नई" },
    coimbatore: { en: "Coimbatore", ta: "கோயம்புத்தூர்", hi: "कोयंबटूर" },
    cuddalore: { en: "Cuddalore", ta: "கடலூர்", hi: "कुड्डालोर" },
    dharmapuri: { en: "Dharmapuri", ta: "தர்மபுரி", hi: "धर्मपुरी" },
    dindigul: { en: "Dindigul", ta: "திண்டுக்கல்", hi: "डिंडीगुल" },
    erode: { en: "Erode", ta: "ஈரோடு", hi: "इरोड" },
    kallakurichi: { en: "Kallakurichi", ta: "கள்ளக்குறிச்சி", hi: "कल्लाकुरिची" },
    kancheepuram: { en: "Kancheepuram", ta: "காஞ்சிபுரம்", hi: "कांचीपुरम" },
    kanniyakumari: { en: "Kanniyakumari", ta: "கன்னியாகுமரி", hi: "कन्याकुमारी" },
    karur: { en: "Karur", ta: "கரூர்", hi: "करूर" },
    krishnagiri: { en: "Krishnagiri", ta: "கிருஷ்ணகிரி", hi: "कृष्णागिरी" },
    madurai: { en: "Madurai", ta: "மதுரை", hi: "मदुरै" },
    mayiladuthurai: { en: "Mayiladuthurai", ta: "மயிலாடுதுறை", hi: "मयिलादुथुराई" },
    nagapattinam: { en: "Nagapattinam", ta: "நாகப்பட்டினம்", hi: "नागपट्टिनम" },
    namakkal: { en: "Namakkal", ta: "நாமக்கல்", hi: "नमक्कल" },
    nilgiris: { en: "Nilgiris", ta: "நீலகிரி", hi: "नीलगिरी" },
    perambalur: { en: "Perambalur", ta: "பெரம்பலூர்", hi: "पेरम्बलुर" },
    pudukkottai: { en: "Pudukkottai", ta: "புதுக்கோட்டை", hi: "पुदुक्कोट्टई" },
    ramanathapuram: { en: "Ramanathapuram", ta: "ராமநாதபுரம்", hi: "रामनाथपुरम" },
    ranipet: { en: "Ranipet", ta: "ராணிப்பேட்டை", hi: "रानीपेट" },
    salem: { en: "Salem", ta: "சேலம்", hi: "सलेम" },
    sivaganga: { en: "Sivaganga", ta: "சிவகங்கை", hi: "शिवगंगा" },
    tenkasi: { en: "Tenkasi", ta: "தென்காசி", hi: "तेनकासी" },
    thanjavur: { en: "Thanjavur", ta: "தஞ்சாவூர்", hi: "तंजावुर" },
    theni: { en: "Theni", ta: "தேனி", hi: "थेनी" },
    thoothukudi: { en: "Thoothukudi", ta: "தூத்துக்குடி", hi: "थूथुकुडी" },
    tiruchirappalli: { en: "Tiruchirappalli", ta: "திருச்சிராப்பள்ளி", hi: "तिरुलचिरापल्ली" },
    tirunelveli: { en: "Tirunelveli", ta: "திருநெல்வேலி", hi: "तिरुनेलवेली" },
    tirupathur: { en: "Tirupathur", ta: "திருப்பத்தூர்", hi: "तिरुप्पुत्तूर" },
    tiruppur: { en: "Tiruppur", ta: "திருப்பூர்", hi: "तिरुपूर" },
    tiruvallur: { en: "Tiruvallur", ta: "திருவள்ளூர்", hi: "तिरुवल्लुर" },
    tiruvannamalai: { en: "Tiruvannamalai", ta: "திருவண்ணாமலை", hi: "तिरुवन्नमलाई" },
    tiruvarur: { en: "Tiruvarur", ta: "திருவாரூர்", hi: "तिरुवरूर" },
    vellore: { en: "Vellore", ta: "வேலூர்", hi: "वेल्लोर" },
    viluppuram: { en: "Viluppuram", ta: "விழுப்புரம்", hi: "विलुप्पुरम" },
    virudhunagar: { en: "Virudhunagar", ta: "விருதுநகர்", hi: "विरुधुनगर" }
};

// Merge dist data into main translations
Object.keys(translations).forEach(lang => {
    translations[lang].districts = {};
    Object.keys(districtData).forEach(distKey => {
        translations[lang].districts[distKey] = districtData[distKey][lang] || districtData[distKey]['en'];
    });
});

// Add missing specific keys for full coverage
translations.en = {
    ...translations.en,
    passenger_login_title: "Passenger Login",
    passenger_login_desc: "Access your journey details",
    create_acc: "Create Account",
    join_now: "Join now to start tracking buses",
    welcome_back: "Welcome Back",
    signin_desc: "Sign in to track your bus instantly",
    mobile_number_label: "MOBILE NUMBER",
    mobile_number_placeholder: "Enter 10-digit number",
    passenger_name_label: "PASSENGER NAME",
    passenger_name_placeholder: "Enter your Name",
    security_check_label: "SECURITY CHECK",
    captcha_placeholder: "Enter the code shown above",
    refresh_captcha_btn: "Refresh",
    admin_prompt: "Are you an admin?",
    staff_login: "Staff Login",
    back_to_districts: "Back to Districts",
    btn_sign_up: "Sign Up",
    err_captcha: "Invalid CAPTCHA code.",
    err_mobile: "Invalid Mobile Number.",
    err_user_not_found: "User not found. Please Sign Up.",
    err_user_exists: "Account exists. Please Sign In."
};

translations.ta = {
    ...translations.ta,
    passenger_login_title: "பயணிகள் உள்நுழைவு",
    passenger_login_desc: "உங்கள் பயண விவரங்களை அணுகவும்",
    create_acc: "கணக்கை உருவாக்கவும்",
    join_now: "பேருந்துகளை கண்காணிக்க இப்போது சேரவும்",
    welcome_back: "மீண்டும் வருக",
    signin_desc: "உடனடியாக பேருந்தை கண்காணிக்க உள்நுழையவும்",
    mobile_number_label: "மொபைல் எண்",
    mobile_number_placeholder: "10 இலக்க எண்ணை உள்ளிடவும்",
    passenger_name_label: "பயணியின் பெயர்",
    passenger_name_placeholder: "உங்கள் பெயரை உள்ளிடவும்",
    security_check_label: "பாதுகாப்பு சோதனை",
    captcha_placeholder: "மேலே உள்ள குறியீட்டை உள்ளிடவும்",
    refresh_captcha_btn: "புதுப்பி",
    admin_prompt: "நீங்கள் நிர்வாகியா?",
    staff_login: "ஊழியர் உள்நுழைவு",
    back_to_districts: "மாவட்டங்களுக்குத் திரும்பு",
    btn_sign_up: "உள்நுழையவும்",
    err_captcha: "தவறான கேப்ட்சா குறியீடு.",
    err_mobile: "தவறான மொபைல் எண்.",
    err_user_not_found: "பயனர் காணப்படவில்லை. பதிவு செய்யவும்.",
    err_user_exists: "கணக்கு உள்ளது. உள்நுழையவும்."
};

translations.hi = {
    ...translations.hi,
    passenger_login_title: "यात्री लॉगिन",
    passenger_login_desc: "अपनी यात्रा विवरण देखें",
    create_acc: "खाता बनाएं",
    join_now: "बस ट्रैक करने के लिए अभी जुड़ें",
    welcome_back: "वापसी पर स्वागत है",
    signin_desc: "तुरंत बस ट्रैक करने के लिए साइन इन करें",
    mobile_number_label: "मोबाइल नंबर",
    mobile_number_placeholder: "10-अंकीय नंबर दर्ज करें",
    passenger_name_label: "यात्री का नाम",
    passenger_name_placeholder: "अपना नाम दर्ज करें",
    security_check_label: "सुरक्षा जांच",
    captcha_placeholder: "ऊपर दिखाया गया कोड दर्ज करें",
    refresh_captcha_btn: "रीफ्रेश",
    admin_prompt: "क्या आप एडमिन हैं?",
    staff_login: "स्टाफ लॉगिन",
    back_to_districts: "जिलों पर वापस जाएं",
    btn_sign_up: "साइन अप करें",
    err_captcha: "अमान्य कैप्चा कोड।",
    err_mobile: "अमान्य मोबाइल नंबर।",
    err_user_not_found: "उपयोगकर्ता नहीं मिला। कृपया साइन अप करें।",
    err_user_exists: "खाता मौजूद है। कृपया साइन इन करें।"
};


function updateText(id, valueOrFn) {
    const el = document.getElementById(id);
    if (!el) return;

    const value = typeof valueOrFn === 'function' ? valueOrFn() : valueOrFn;
    if (value) el.textContent = value;
}

// Initialize on load
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('user_theme') || 'dark';
    const savedLang = localStorage.getItem('user_lang') || 'en';

    applyTheme(savedTheme);
    applyLanguage(savedLang);
});

// Sync across tabs
window.addEventListener('storage', (e) => {
    if (e.key === 'user_theme') {
        applyTheme(e.newValue);
    }
    if (e.key === 'user_lang') {
        applyLanguage(e.newValue);
    }
});

/* ==========================================================================
   Continuous Animation Sync Logic
   ========================================================================== */
function syncAnimations() {
    const KEY = 'animation_start_time';
    let startTime = localStorage.getItem(KEY);

    // Set start time if not exists (first visit)
    if (!startTime) {
        startTime = Date.now().toString();
        localStorage.setItem(KEY, startTime);
    }

    // Calculate elapsed time in seconds
    const elapsed = (Date.now() - parseInt(startTime, 10)) / 1000;

    // Get all circle elements
    const circles = document.querySelectorAll('.circles li');

    circles.forEach(li => {
        // Get computed style for duration and delay
        // We must get this BEFORE setting new delay, but standard style sheets are static so it's fine.
        // However, we need the CSS-defined duration.
        const computedStyle = window.getComputedStyle(li);
        const durationStr = computedStyle.animationDuration;
        const delayStr = computedStyle.animationDelay;

        // Parse values
        let duration = parseFloat(durationStr) || 25; // Default fallback
        let originalDelay = parseFloat(delayStr) || 0;

        // Calculate new effective delay
        // newDelay = originalDelay - elapsed
        // This makes the animation start "in the past" by exactly how much time has passed
        const newDelay = originalDelay - elapsed;

        // Apply (use style directly to override CSS)
        li.style.animationDelay = `${newDelay}s`;
    });
}

// Run synchronization immediately
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', syncAnimations);
} else {
    syncAnimations();
}
