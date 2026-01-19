<?php
/**
 * Language Support - Soumis Collections
 * Supports: English, Bengali, Hindi, Gujarati, Tamil
 */

if (session_status() === PHP_SESSION_NONE) {
  @session_start();
}

// Get current language setting
$currentLanguage = $_SESSION['settings']['language'] ?? 'English';

// Language translations
$translations = [
  'English' => [
    'welcome' => 'Welcome',
    'home' => 'Home',
    'products' => 'Products',
    'collections' => 'Collections',
    'wholesale' => 'Wholesale',
    'cart' => 'Cart',
    'profile' => 'My Profile',
    'orders' => 'My Orders',
    'wishlist' => 'Wishlist',
    'settings' => 'Settings',
    'logout' => 'Logout',
    'login' => 'Sign In',
    'signup' => 'Create Account',
    'hello' => 'Hello',
    'my_account' => 'My Account',
    'trending' => 'Trending',
    'new_arrivals' => 'New Arrivals',
    'best_sellers' => 'Best Sellers',
    'price' => 'Price',
    'add_to_cart' => 'Add to Cart',
    'shop_now' => 'Shop Now',
    'search' => 'Search',
    'no_results' => 'No results found',
    'loading' => 'Loading...',
    'error' => 'Error',
    'success' => 'Success',
  ],
  'Bengali' => [
    'welcome' => 'স্বাগতম',
    'home' => 'হোম',
    'products' => 'পণ্য',
    'collections' => 'সংগ্রহ',
    'wholesale' => 'পাইকারি',
    'cart' => 'কার্ট',
    'profile' => 'আমার প্রোফাইল',
    'orders' => 'আমার অর্ডার',
    'wishlist' => 'পছন্দের তালিকা',
    'settings' => 'সেটিংস',
    'logout' => 'লগ আউট',
    'login' => 'সাইন ইন',
    'signup' => 'অ্যাকাউন্ট তৈরি করুন',
    'hello' => 'হ্যালো',
    'my_account' => 'আমার অ্যাকাউন্ট',
    'trending' => 'ট্রেন্ডিং',
    'new_arrivals' => 'নতুন আগমন',
    'best_sellers' => 'সেরা বিক্রেতা',
    'price' => 'মূল্য',
    'add_to_cart' => 'কার্টে যোগ করুন',
    'shop_now' => 'এখনই কিনুন',
    'search' => 'অনুসন্ধান',
    'no_results' => 'কোন ফলাফল পাওয়া যায়নি',
    'loading' => 'লোড হচ্ছে...',
    'error' => 'ত্রুটি',
    'success' => 'সফল',
  ],
  'Hindi' => [
    'welcome' => 'स्वागत है',
    'home' => 'होम',
    'products' => 'उत्पाद',
    'collections' => 'संग्रह',
    'wholesale' => 'थोक',
    'cart' => 'कार्ट',
    'profile' => 'मेरी प्रोफाइल',
    'orders' => 'मेरे ऑर्डर',
    'wishlist' => 'विशलिस्ट',
    'settings' => 'सेटिंग्स',
    'logout' => 'लॉग आउट',
    'login' => 'साइन इन',
    'signup' => 'खाता बनाएं',
    'hello' => 'नमस्ते',
    'my_account' => 'मेरा खाता',
    'trending' => 'ट्रेंडिंग',
    'new_arrivals' => 'नए आगमन',
    'best_sellers' => 'बेस्ट सेलर्स',
    'price' => 'कीमत',
    'add_to_cart' => 'कार्ट में जोड़ें',
    'shop_now' => 'अभी खरीदारी करें',
    'search' => 'खोज',
    'no_results' => 'कोई परिणाम नहीं',
    'loading' => 'लोड हो रहा है...',
    'error' => 'त्रुटि',
    'success' => 'सफल',
  ],
  'Gujarati' => [
    'welcome' => 'આપનું સ્વાગત છે',
    'home' => 'હોમ',
    'products' => 'ઉત્પાદનો',
    'collections' => 'સંગ્રહ',
    'wholesale' => 'હોલસેલ',
    'cart' => 'કાર્ટ',
    'profile' => 'મારી પ્રોફાઇલ',
    'orders' => 'મારા ઓર્ડર્સ',
    'wishlist' => 'વિશલિસ્ટ',
    'settings' => 'સેટિંગ્સ',
    'logout' => 'લૉગ આઉટ',
    'login' => 'સાઇન ઇન',
    'signup' => 'ખાતું બનાવો',
    'hello' => 'નમસ્તે',
    'my_account' => 'મારું ખાતું',
    'trending' => 'ટ્રેન્ડિંગ',
    'new_arrivals' => 'નવી આગમન',
    'best_sellers' => 'બેસ્ટ સેલર્સ',
    'price' => 'કિંમત',
    'add_to_cart' => 'કાર્ટમાં ઉમેરો',
    'shop_now' => 'હવે કે Shop કરો',
    'search' => 'શોધ',
    'no_results' => 'કોઈ પરિણામ નથી',
    'loading' => 'લોડ થઇ રહ્યું છે...',
    'error' => 'ભૂલ',
    'success' => 'સફળ',
  ],
  'Tamil' => [
    'welcome' => 'வரவேற்கிறோம்',
    'home' => 'முகப்பு',
    'products' => 'பொருட்கள்',
    'collections' => 'சংக்கલనங்கள்',
    'wholesale' => 'மொத்த வியாபாரம்',
    'cart' => 'வண்டி',
    'profile' => 'என் சுயவிவரம்',
    'orders' => 'என் ஆர்டர்கள்',
    'wishlist' => 'விருப்ப பட்டியல்',
    'settings' => 'அமைப்புகள்',
    'logout' => 'வெளியேறு',
    'login' => 'உள்நுழைக',
    'signup' => 'கணக்கை உருவாக்கு',
    'hello' => 'வணக்கம்',
    'my_account' => 'என் கணக்கு',
    'trending' => 'மிக சூட்டாக உள்ள',
    'new_arrivals' => 'புதிய வருகைகள்',
    'best_sellers' => 'சிறந்த விற்பனையாளர்கள்',
    'price' => 'விலை',
    'add_to_cart' => 'வண்டிக்கு சேர்க்கவும்',
    'shop_now' => 'இப்போது கடை',
    'search' => 'தேடல்',
    'no_results' => 'முடிவுகள் எதுவும் கிடைக்கவில்லை',
    'loading' => 'ஏற்றுகிறது...',
    'error' => 'பிழை',
    'success' => 'வெற்றி',
  ],
];

/**
 * Get translated text
 * @param string $key Translation key
 * @param string $language Language code
 * @return string Translated text
 */
function __($key, $language = null) {
  global $translations, $currentLanguage;
  
  $lang = $language ?? $currentLanguage ?? 'English';
  
  if (isset($translations[$lang][$key])) {
    return $translations[$lang][$key];
  }
  
  // Fallback to English
  return $translations['English'][$key] ?? $key;
}

/**
 * Get all translations for current language
 * @return array Translations
 */
function getLanguageStrings() {
  global $translations, $currentLanguage;
  return $translations[$currentLanguage] ?? $translations['English'];
}

/**
 * Get available languages
 * @return array Languages
 */
function getAvailableLanguages() {
  return [
    'English' => '🇬🇧 English',
    'Bengali' => '🇧🇩 Bengali (বাংলা)',
    'Hindi' => '🇮🇳 Hindi (हिंदी)',
    'Gujarati' => '🇮🇳 Gujarati (ગુજરાતી)',
    'Tamil' => '🇮🇳 Tamil (தமிழ்)',
  ];
}
