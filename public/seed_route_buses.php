<?php
/**
 * SEED SCRIPT: Generate 700 Route Buses per District
 * Run this once via browser: http://localhost/smart-bus-portal/public/seed_route_buses.php
 */
set_time_limit(0);
ini_set('memory_limit', '512M');

require_once 'db.php';

// Check if using mysqli procedural or OOP
if (isset($conn) && $conn instanceof mysqli) {
    $db = $conn;
} else {
    $db = new mysqli("localhost", "root", "", "smart_bus_portal");
}
if ($db->connect_error) die("Connection failed: " . $db->connect_error);
$db->set_charset("utf8mb4");

echo "<h2>Smart Bus Portal - Route Bus Seeder</h2><pre>\n";

// ============================================================
// Step 0: Ensure all 38 platform incharges exist
// ============================================================
echo "Ensuring all 38 platform incharges exist...\n";
$allIncharges = [
    ['tirunelveli_admin','admin','Tirunelveli'],['chennai_admin','admin','Chennai'],
    ['madurai_admin','admin','Madurai'],['coimbatore_admin','admin','Coimbatore'],
    ['salem_admin','admin','Salem'],['tiruchirappalli_admin','admin','Tiruchirappalli'],
    ['tiruppur_admin','admin','Tiruppur'],['erode_admin','admin','Erode'],
    ['vellore_admin','admin','Vellore'],['thoothukudi_admin','admin','Thoothukudi'],
    ['dindigul_admin','admin','Dindigul'],['thanjavur_admin','admin','Thanjavur'],
    ['ranipet_admin','admin','Ranipet'],['sivaganga_admin','admin','Sivaganga'],
    ['karur_admin','admin','Karur'],['ramanathapuram_admin','admin','Ramanathapuram'],
    ['virudhunagar_admin','admin','Virudhunagar'],['tiruvannamalai_admin','admin','Tiruvannamalai'],
    ['nilgiris_admin','admin','Nilgiris'],['namakkal_admin','admin','Namakkal'],
    ['cuddalore_admin','admin','Cuddalore'],['kancheepuram_admin','admin','Kancheepuram'],
    ['kanniyakumari_admin','admin','Kanniyakumari'],['nagapattinam_admin','admin','Nagapattinam'],
    ['viluppuram_admin','admin','Viluppuram'],['tiruvallur_admin','admin','Tiruvallur'],
    ['dharmapuri_admin','admin','Dharmapuri'],['krishnagiri_admin','admin','Krishnagiri'],
    ['ariyalur_admin','admin','Ariyalur'],['perambalur_admin','admin','Perambalur'],
    ['pudukkottai_admin','admin','Pudukkottai'],['theni_admin','admin','Theni'],
    ['tiruvarur_admin','admin','Tiruvarur'],['tenkasi_admin','admin','Tenkasi'],
    ['mayiladuthurai_admin','admin','Mayiladuthurai'],['chengalpattu_admin','admin','Chengalpattu'],
    ['tirupathur_admin','admin','Tirupathur'],['kallakurichi_admin','admin','Kallakurichi']
];
foreach ($allIncharges as $inc) {
    $db->query("INSERT IGNORE INTO platform_incharges (username, password, district) VALUES ('{$inc[0]}','{$inc[1]}','{$inc[2]}')");
}

// Build incharge_id lookup by district name
$inchargeMap = [];
$r = $db->query("SELECT id, district FROM platform_incharges");
while ($row = $r->fetch_assoc()) {
    $inchargeMap[$row['district']] = (int)$row['id'];
}
echo "Found " . count($inchargeMap) . " platform incharges.\n";

// Clean up any existing Route Bus data
echo "Cleaning up existing Route Bus data...\n";
$db->query("DELETE FROM attendance WHERE bus_id IN (SELECT id FROM buses WHERE bus_type = 'Route Bus')");
$db->query("DELETE FROM buses WHERE bus_type = 'Route Bus'");
echo "Cleanup done.\n\n";

// ============================================================
// DISTRICT DATA: Towns, RTO codes
// ============================================================
$districts = [
  ['name'=>'Tirunelveli','rto'=>'72','towns'=>['Tirunelveli','Palayamkottai','Ambasamudram','Tenkasi','Sankarankovil','Nanguneri','Radhapuram','Cheranmahadevi','Kalakkad','Papanasam','Kadayanallur','Shenkottai','Sivagiri','Puliyangudi','Alangulam','Valliyoor','Melapalayam','Mukkudal','Pettai','Vikramasingapuram','Vasudevanallur','Keezhapavoor','Manur','Vickramasingapuram','Surandai']],
  ['name'=>'Chennai','rto'=>'01','towns'=>['Chennai','Tambaram','Chromepet','Guindy','Adyar','T.Nagar','Egmore','Perambur','Avadi','Ambattur','Porur','Maduravoyal','Tondiarpet','Royapuram','Washermanpet','Kilpauk','Nungambakkam','Mylapore','Triplicane','Saidapet','Velachery','Medavakkam','Pallavaram','St.Thomas Mount','Alandur']],
  ['name'=>'Madurai','rto'=>'45','towns'=>['Madurai','Melur','Usilampatti','Thirumangalam','Peraiyur','Vadipatti','Sholavandan','Kalligudi','T.Kallupatti','Sedapatti','Alanganallur','Elumalai','Kottampatti','Othakadai','Paravai','Thirupparankundram','Anaiyur','Karungalakudi','Chellampatti','Samayanallur','Virattipathu','Avaniapuram','Teppakulam','Tallakulam','Vilangudi']],
  ['name'=>'Coimbatore','rto'=>'38','towns'=>['Coimbatore','Pollachi','Mettupalayam','Sulur','Annur','Kinathukadavu','Valparai','Madukkarai','Perur','Karamadai','Thondamuthur','Sarcarsamakulam','Singanallur','Gandhipuram','Peelamedu','Saravanampatti','Vadavalli','Kovaipudur','Ukkadam','Podanur','Irugur','Narasimhanaickenpalayam','Chettipalayam','Othakalmandapam','Avinashi']],
  ['name'=>'Salem','rto'=>'30','towns'=>['Salem','Attur','Mettur','Omalur','Gangavalli','Edappadi','Yercaud','Panamarathupatti','Vazhapadi','Thalaivasal','Sankari','Konganapuram','Kadayampatti','Ayothiapattinam','Ammapet','Hasthampatti','Suramangalam','Fairlands','Salem Junction','Magudanchavadi','Nangavalli','Kolathur','Belur','Peddanaickenpalayam','Valasaiyur']],
  ['name'=>'Tiruchirappalli','rto'=>'45','towns'=>['Tiruchirappalli','Srirangam','Lalgudi','Musiri','Thottiyam','Thuraiyur','Mannachanallur','Manapparai','Marungapuri','Uppiliapuram','Pullambadi','Thiruverumbur','K.K.Nagar','Cantonment','Woraiyur','Ariyamangalam','Golden Rock','Ponmalai','Karumandapam','Crawford','Samayapuram','Manikandam','Inungur','Vaiyampatti','Viralimalai']],
  ['name'=>'Tiruppur','rto'=>'39','towns'=>['Tiruppur','Avinashi','Palladam','Dharapuram','Kangeyam','Uthukuli','Udumalpet','Gudimangalam','Madathukulam','Vellakoil','Muthur','Tiruppur South','Tiruppur North','Mangalam','Nallur','Chettipalayam','Veerapandi','Perumanallur','Kundadam','Mulanur','Pongalur','Kaniyur','Avinashipalayam','Angeripalayam','Iduvai']],
  ['name'=>'Erode','rto'=>'33','towns'=>['Erode','Bhavani','Gobichettipalayam','Sathyamangalam','Perundurai','Anthiyur','Nambiyur','Kodumudi','Chennimalai','Modakkurichi','Kavundapadi','Chithode','Surampatti','Karungalpalayam','Veerappanchatram','Sivagiri','Bhavanisagar','Ammapettai','Talavadi','Elanthakuttai','Thingalur','Kollankoil','Unjalur','Kasipalayam','Moolapalayam']],
  ['name'=>'Vellore','rto'=>'23','towns'=>['Vellore','Katpadi','Gudiyatham','Vaniyambadi','Ambur','Arani','Arcot','Sholinghur','Wallajah','Melvisharam','Sathuvachari','Konavattam','Latteri','Kannamangalam','Odugathur','Poigai','Kalavai','Pennathur','Anaicut','Virinchipuram','Rangapuram','Thottapalayam','Saidapet','Kagithapattarai','Dharapadavedu']],
  ['name'=>'Thoothukudi','rto'=>'76','towns'=>['Thoothukudi','Kovilpatti','Tiruchendur','Kayalpattinam','Ettayapuram','Srivaikundam','Sathankulam','Vilathikulam','Ottapidaram','Kalugumalai','Pudur','Arumuganeri','Authoor','Kadambur','Kulasekarapattinam','Manapaddu','Perungulam','Pasuvanthanai','Kayathar','Alwarthirunagari','Nazareth','Punnakayal','Udangudi','Paramankurichi','Thisayanvilai']],
  ['name'=>'Dindigul','rto'=>'42','towns'=>['Dindigul','Palani','Kodaikanal','Oddanchatram','Natham','Vedasandur','Nilakottai','Athoor','Batlagundu','Guziliamparai','Shanarpatti','Chinnalapatti','Sitharevu','Reddiarchatram','Vadamadurai','Thadikombu','Sempatti','Pallapatti','Kannivadi','Ayakudi','Poombarai','Thandikudi','Snp Colony','Begampur','Nagalnaickenpatti']],
  ['name'=>'Thanjavur','rto'=>'48','towns'=>['Thanjavur','Kumbakonam','Pattukkottai','Orathanadu','Peravurani','Papanasam','Thiruvaiyaru','Thiruvidaimarudur','Ayyampettai','Vallam','Sengipatti','Madukkur','Aranthangi','Budalur','Thiruppanandal','Swamimalai','Aduthurai','Thirunageswaram','Darasuram','Needamangalam','Grand Anaicut','Melattur','Ammapettai','Thirukattupalli','Thiruvonam']],
  ['name'=>'Ranipet','rto'=>'23','towns'=>['Ranipet','Arakkonam','Walajapet','Arcot','Sholinghur','Nemili','Timiri','Kalavai','Kaveripakkam','Thakkolam','Banavaram','Melvisharam','Panapakkam','Vilapakkam','Sumaithangi','Pallalakuppam','Arani Road','Ranipet Cantonment','Ponnai','Periyapalayam','Mambakkam','Valluvambakkam','Sholavaramb','Thirumalapur','Konavattam']],
  ['name'=>'Sivaganga','rto'=>'56','towns'=>['Sivaganga','Karaikudi','Devakottai','Manamadurai','Ilayangudi','Tirupathur','Kallal','Singampunari','Kalayarkovil','S.Pudur','Nattarasankottai','Thirupuvanam','Kanadukathan','Pallathur','Kothamangalam','Kalaiyarkovil','Sakkottai','Maniyachi','Kandramanickam','Pillayarpatti','Kulipirai','Thiruppachethi','Ponnamaravathi','Sathirakudi','Nerkuppai']],
  ['name'=>'Karur','rto'=>'28','towns'=>['Karur','Kulithalai','Krishnarayapuram','Aravakurichi','Thanthoni','Pugalur','Velayuthampalayam','Manmangalam','Thogamalai','Pallapatti','Vangal','Vellianai','Nerur','Mayanur','Kadavur','Puliyur','Nachandupatti','K.Paramathi','Uppidamangalam','Thennilai','Karur Town','Jayankondam Road','Musiri Road','Pavithram','Pangudi']],
  ['name'=>'Ramanathapuram','rto'=>'57','towns'=>['Ramanathapuram','Paramakudi','Rameswaram','Kamuthi','Mudukulathur','Thiruvadanai','Kadaladi','Mandapam','Uchipuli','Thondi','Abiramam','Bogalur','Devipattinam','Erwadi','Kilakarai','R.S.Mangalam','Sayalkudi','Nainarkovil','Parthibanur','Sikkal','Tiruppullani','Pamban','Keelakidaram','Vannangundu','Chatrapatti']],
  ['name'=>'Virudhunagar','rto'=>'56','towns'=>['Virudhunagar','Sivakasi','Rajapalayam','Aruppukkottai','Sattur','Srivilliputhur','Watrap','Tiruchuli','Kariyapatti','Narikudi','Vembakottai','Sundarapandiam','Mallankinaru','Seithur','Mamsapuram','P.Agaraharam','W.Pudupatti','Koomapatti','Paralachi','Pillaiyarkulam','Keelarajakularaman','Therku Virudhunagar','Thayilpatti','Achampatti','Sathirakudi']],
  ['name'=>'Tiruvannamalai','rto'=>'21','towns'=>['Tiruvannamalai','Polur','Cheyyar','Arani','Chengam','Vandavasi','Kalasapakkam','Chetpet','Desur','Thandarampattu','Jamunamarathur','Keelpennathur','Kilpennathur','Mangalam','Vettavalam','Thurinjapuram','West Arni','Pernamallur','Pudupalayam','Kanji','Sathanur Dam','Jawadhu Hills','Kovilur','Peranamallur','Avalurpet']],
  ['name'=>'Nilgiris','rto'=>'43','towns'=>['Ooty','Coonoor','Kotagiri','Gudalur','Pandalur','Wellington','Kundah','Ketti','Lovedale','Aruvankadu','Devala','Cherambadi','Bikkapathimund','Masinagudi','Mudumalai','Kothagiri','Emerald','Mangorange','Hubbathalai','Sholur','Naduvattam','Pykara','Avalanche','Doddabetta','Yellanahalli']],
  ['name'=>'Namakkal','rto'=>'31','towns'=>['Namakkal','Rasipuram','Tiruchengode','Paramathi','Kolli Hills','Mohanur','Kumarapalayam','Velur','Erumapatty','Mallasamudram','Kabilarmalai','Pallipalayam','Vennandur','Puduchatram','Sendarapatti','Namagiripettai','Jedarpalayam','P.Velur','Pothanur','Idayapatti','Pandamangalam','Thimmanaickenpatti','Mangalapuram','Kalappanaickenpatti','Kaveripattinam']],
  ['name'=>'Cuddalore','rto'=>'18','towns'=>['Cuddalore','Chidambaram','Virudhachalam','Panruti','Kattumannarkoil','Bhuvanagiri','Kurinjipadi','Melpattampakkam','Nellikuppam','C.Mutlur','Killai','Parangipettai','Sethiyathope','Tittakudi','Mangalur','Vazhisodhanai','Annamalainagar','Lalpet','Vriddhachalam Town','Neyveli','Kammapuram','Pennadam','Kollidam','Keerapalayam','Marungur']],
  ['name'=>'Kancheepuram','rto'=>'27','towns'=>['Kancheepuram','Sriperumbudur','Uthiramerur','Kundrathur','Walajabad','Oragadam','Thiruporur','Mahabalipuram','Kovalam','Kelambakkam','Padappai','Singaperumalkoil','Mangadu','Madambakkam','Thaiyur','Sholinganallur','Thiruneermalai','Anakaputhur','Pammal','Pallavaram','Vandalur','Chitlapakkam','Mudichur','Perungalathur','Tambaram West']],
  ['name'=>'Kanniyakumari','rto'=>'74','towns'=>['Nagercoil','Marthandam','Thuckalay','Kuzhithurai','Colachel','Kanyakumari','Padmanabhapuram','Eraniel','Suchindram','Thiruvattar','Rajakkamangalam','Kalkulam','Agastheeswaram','Killiyoor','Melpuram','Arumanai','Boothapandi','Karungal','Monday Market','Friday Market','Kadiapattinam','Manavalakurichi','Enayam','Puthenthurai','Kottar']],
  ['name'=>'Nagapattinam','rto'=>'49','towns'=>['Nagapattinam','Thiruvarur','Vedaranyam','Mayiladuthurai','Sirkazhi','Tharangambadi','Velankanni','Thirukkuvalai','Kilvelur','Kuttalam','Thiruthuraipoondi','Kodavasal','Mannargudi','Needamangalam','Nannilam','Thiruppondi','Muthupet','Porayar','Sembanarkoil','Vaitheeswaran Koil','Kollidam','Karaikal','Akkur','Keezhaiyur','Talainayar']],
  ['name'=>'Viluppuram','rto'=>'20','towns'=>['Viluppuram','Tindivanam','Gingee','Kallakurichi','Ulundurpettai','Sankarapuram','Thirukoilur','Vandavasi','Rishivandiyam','Thiruvennainallur','Marakkanam','Chinnasalem','Mugaiyur','Kanai','Koliyanur','Vikravandi','Mailam','Perumbakkam','Thirunavalur','Vadakkupattu','Olakkur','Manalurpet','Mundiyampakkam','Karanai','Valathi']],
  ['name'=>'Tiruvallur','rto'=>'12','towns'=>['Tiruvallur','Poonamallee','Avadi','Ambattur','Thirumullaivoyal','Gummidipoondi','Uthukottai','Ponneri','RK Pet','Tiruttani','Pallipattu','Kadambathur','Nemam','Periyapalayam','Minjur','Ennore','Red Hills','Madhavaram','Manali','Thiruninravur','Thiruvalangadu','Sriperumbudur Road','Thiruverkadu','Peravallur','Kolathur']],
  ['name'=>'Dharmapuri','rto'=>'29','towns'=>['Dharmapuri','Harur','Palacode','Pennagaram','Nallampalli','Karimangalam','Pappireddipatti','Morappur','Bommidi','Kadathur','Marandahalli','Eriyur','Ondikili','Elumathur','Thumberi','Kambainallur','Ittamankalipatti','A.Gollapalli','Indur','Dharmapuri Town','Kavanur','Pottaneri','Periyanahalli','Manjakuttai','Nagadasampatti']],
  ['name'=>'Krishnagiri','rto'=>'34','towns'=>['Krishnagiri','Hosur','Pochampalli','Uthangarai','Denkanikottai','Bargur','Shoolagiri','Kaveripattinam','Mathur','Thally','Kelamangalam','Pannandur','Veppanapalli','Royakottah','Nagarasampatti','Kundarapalli','Kandikuppam','Samalpatti','Sulagiri','Berigai','Gattiganahalli','Bagalur','Rayakottai','Anchetty','Periyamottur']],
  ['name'=>'Ariyalur','rto'=>'44','towns'=>['Ariyalur','Jayankondam','Sendurai','Andimadam','Udayarpalayam','T.Palur','Thirumanur','Govindapuram','Varadarajanpettai','Labbaikudikadu','Meensurutti','Ariyalur Town','Ponparappi','Mangalamedu','Thellar','V.Kalathur','Vikramam','Reddipalayam','Nannai','Silambur','Killai Road','Narasingapuram','Kollapuram','Elemangalam','Ponnagar']],
  ['name'=>'Perambalur','rto'=>'44','towns'=>['Perambalur','Kunnam','Veppanthattai','Alathur','Chettikulam','Labbaikudikadu','Siruvachur','Elambalur','Ammapalayam','Arumbavur','Kurumbalur','Perambalur Town','Melapuliyankulam','V.Kalathur Road','Veppur','Poolambadi','Nakkasalem','Valikandapuram','Vengalam','Sengattupatti','Keelakurichi','Sathamangalam','Esanai','Kottarai','Padalur']],
  ['name'=>'Pudukkottai','rto'=>'53','towns'=>['Pudukkottai','Aranthangi','Alangudi','Avudaiyarkoil','Illupur','Gandarvakottai','Thirumayam','Karambakudi','Manamelkudi','Kunnandarkoil','Annavasal','Ponnamaravathi','Kottaipattinam','Sittannavasal','Viralimalai','Arimalam','Narthamalai','Varappur','Mimisal','Kodumbalur','Vallathirakottai','Keeranur','Thiruvarankulam','Enathi','Senthurai']],
  ['name'=>'Theni','rto'=>'46','towns'=>['Theni','Periyakulam','Bodinayakanur','Uthamapalayam','Andipatti','Cumbum','Chinnamanur','Gudalur','Myladumparai','Kadamalaigundu','Thevaram','Veerapandi','Odaipatti','Kambam','Rasingapuram','Lakshmipuram','Theni Allinagaram','Goodalur','Jambunathapuram','Bodi West','Markayankottai','Surulipatti','Kottakudi','High Wavy','Megamalai']],
  ['name'=>'Tiruvarur','rto'=>'50','towns'=>['Tiruvarur','Mannargudi','Thiruthuraipoondi','Needamangalam','Kodavasal','Nannilam','Valangaiman','Kudavasal','Kottur','Muthupettai','Thiruvengadu','Agarakattu','Rajapuram','Kamalapuram','Sannanallur','Koothanallur','Vaduvur','Tiruvadi','Engan','Peralam','Tiruvarur Town','Pulavarinallur','Ayyampettai','Melattur','Alathambadi']],
  ['name'=>'Tenkasi','rto'=>'72','towns'=>['Tenkasi','Sankarankovil','Kadayanallur','Shenkottai','Kadayam','Surandai','Vasudevanallur','Alangulam','Sivagiri','Puliyangudi','Meignanapuram','Keelapavoor','Pavoorchatram','Kottarakara Road','Ayikudi','Ilayarasanendal','Kavalkinaru','Panpoli','Thiruvengadam','Courtalllam','Pattakaranpudur','Melagaram','Ilanchi','Nethaji Nagar','Melaneelithanallur']],
  ['name'=>'Mayiladuthurai','rto'=>'49','towns'=>['Mayiladuthurai','Sirkazhi','Kuthalam','Kollidam','Sembanarkoil','Tharangambadi','Poompuhar','Vaitheeswaran Koil','Poombuhar','Tranquebar','Thirukkadaiyur','Mayuram','Manjakuppam','Koradachery','Dharumapuram','Thiruvenkadu','Vaitheeswaran','Pandanallur','Kezhaperumpallam','Melaperumpallam','Kutralam Road','Nidur','Thirumullaivasal','Vellapallam','Akkur']],
  ['name'=>'Chengalpattu','rto'=>'15','towns'=>['Chengalpattu','Mahabalipuram','Chingleput','Thiruporur','Tambaram','Maduranthakam','Uthiramerur','Kalpakkam','Kelambakkam','Guduvancheri','Vandalur','Urapakkam','Singaperumalkoil','Padappai','Kovalam','Thirukalukundram','Acharapakkam','Chithamur','Lathur','Vallam','Paranur','Kolapakkam','Perungalathur','Potheri','Kayar']],
  ['name'=>'Tirupathur','rto'=>'21','towns'=>['Tirupathur','Vaniyambadi','Ambur','Natrampalli','Jolarpet','Alangayam','Kandili','Pudupettai','Madhanur','Tirupathur Town','Natrampalli Town','Thirthamangalam','Karvetinagar','Valathur','Vengalapuram','Ammundi','Selliamman Nagar','Perumalmottur','Annamangalam','Paradarami','Kathirvedu','Kottamalli','Kokkampatti','Pudurnadu','Kaveripalayam']],
  ['name'=>'Kallakurichi','rto'=>'32','towns'=>['Kallakurichi','Ulundurpettai','Sankarapuram','Chinnasalem','Rishivandiyam','Tirukoilur','Thirunavalur','Mugaiyur','Manalurpet','Kallakurichi Town','Emperumalpuram','Kandarakottai','Vadakkanandal','Periyanesalur','K.V.Kuppam','Thalamangalam','Vellaiyankuppam','Puthupalayam','Arasur','Belur','Ennayiram','Thiruvarangam','Marquis Street','Thiyagadurugam','Kottakuppam']]
];

// ============================================================
// GENERATE ROUTES WITH MULTIPLE VARIATIONS PER DISTRICT
// ============================================================
function generateDistrictRoutes($district) {
    $towns = $district['towns'];
    $name = $district['name'];
    $routes = [];
    $numTowns = count($towns);

    // Generate route pairs with 2-3 path variations each
    for ($i = 0; $i < $numTowns - 1; $i++) {
        for ($j = $i + 1; $j < min($i + 5, $numTowns); $j++) {
            $from = $towns[$i];
            $to = $towns[$j];

            // Variation 1: Direct via nearby intermediate stops
            $stops1 = [$from];
            $mid1 = ($i + $j) / 2;
            for ($k = $i + 1; $k < $j; $k++) {
                if (count($stops1) < 8) $stops1[] = $towns[$k];
            }
            if (count($stops1) < 6) {
                // pad with nearby towns
                foreach ($towns as $idx => $t) {
                    if ($idx > $j && count($stops1) < 7 && !in_array($t, $stops1)) $stops1[] = $t;
                }
            }
            $stops1[] = $to;
            $via1 = count($stops1) > 2 ? $stops1[1] : '';
            $routes[] = [
                'route' => "$from - $to" . ($via1 ? " via $via1" : ''),
                'stops' => array_slice($stops1, 0, 9)
            ];

            // Variation 2: Reverse direction with different intermediate
            $stops2 = [$from];
            for ($k = $j + 1; $k < min($j + 4, $numTowns); $k++) {
                if (count($stops2) < 7 && !in_array($towns[$k], $stops1)) $stops2[] = $towns[$k];
            }
            // Add some from before $i
            for ($k = max(0, $i - 3); $k < $i; $k++) {
                if (count($stops2) < 7 && !in_array($towns[$k], $stops2)) $stops2[] = $towns[$k];
            }
            $stops2[] = $to;
            $via2 = count($stops2) > 2 ? $stops2[1] : '';
            if ($via2 && $via2 !== $via1) {
                $routes[] = [
                    'route' => "$from - $to via $via2",
                    'stops' => array_slice($stops2, 0, 9)
                ];
            }

            // Variation 3: Loop route (occasionally)
            if (($i + $j) % 3 === 0 && $j + 2 < $numTowns) {
                $stops3 = [$from, $towns[$j+1]];
                if ($j + 2 < $numTowns) $stops3[] = $towns[$j+2];
                if ($i + 1 < $j) $stops3[] = $towns[$i+1];
                if (count($stops3) < 6) {
                    $extra = ($i + $j + 2) % $numTowns;
                    if (!in_array($towns[$extra], $stops3)) $stops3[] = $towns[$extra];
                }
                if (count($stops3) < 6) {
                    $extra = ($i + $j + 5) % $numTowns;
                    if (!in_array($towns[$extra], $stops3)) $stops3[] = $towns[$extra];
                }
                $stops3[] = $to;
                $routes[] = [
                    'route' => "$from - $to via " . $stops3[1],
                    'stops' => array_slice($stops3, 0, 9)
                ];
            }
        }
    }

    // Also add circular/return routes within the district
    for ($i = 0; $i < min(10, $numTowns); $i++) {
        $circStops = [];
        $start = $towns[$i];
        $indices = range(0, $numTowns - 1);
        shuffle($indices);
        $circStops[] = $start;
        foreach ($indices as $idx) {
            if ($towns[$idx] !== $start && count($circStops) < 8) {
                $circStops[] = $towns[$idx];
            }
        }
        $circStops[] = $start; // circular
        $routes[] = [
            'route' => "$start - {$circStops[1]} - $start (Circular)",
            'stops' => array_slice($circStops, 0, 9)
        ];
    }

    return $routes;
}

// ============================================================
// GENERATE SHIFT TIMINGS
// ============================================================
function generateShifts($busIndex) {
    $baseHour = 5 + ($busIndex % 4); // 5, 6, 7, 8
    $shift1 = sprintf('%02d:%02d:00', $baseHour, ($busIndex * 7) % 60);
    $shift2 = sprintf('%02d:%02d:00', $baseHour + 3, ($busIndex * 11) % 60);
    $shift3 = sprintf('%02d:%02d:00', $baseHour + 7, ($busIndex * 13) % 60);
    $shift4 = sprintf('%02d:%02d:00', min($baseHour + 11, 21), ($busIndex * 17) % 60);
    return [$shift1, $shift2, $shift3, $shift4];
}

// ============================================================
// MAIN INSERTION LOOP
// ============================================================
$totalInserted = 0;
$busCounter = 0;

foreach ($districts as $district) {
    $distName = $district['name'];
    $inchargeId = $inchargeMap[$distName] ?? 0;
    $rtoCode = $district['rto'];
    
    if ($inchargeId === 0) { echo "  SKIP: No incharge for $distName\n"; continue; }
    echo "Processing $distName (incharge_id=$inchargeId, RTO=TN $rtoCode)...\n";
    flush();

    // Generate all possible routes for this district
    $routes = generateDistrictRoutes($district);
    $routeCount = count($routes);
    
    if ($routeCount === 0) {
        echo "  WARNING: No routes generated for $distName!\n";
        continue;
    }

    // We need 700 buses, cycle through routes
    $distBusCount = 0;
    $batchValues = [];
    $batchSize = 50; // Insert in batches of 50

    for ($b = 0; $b < 700; $b++) {
        $busCounter++;
        $routeIdx = $b % $routeCount;
        $route = $routes[$routeIdx];
        
        // Generate globally unique bus number using busCounter
        $letters = ['A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $letterIdx = intdiv($busCounter, 9999) % count($letters);
        $busNum = sprintf('TN %s %s %04d', $rtoCode, $letters[$letterIdx], ($busCounter % 9999) + 1);
        
        $shifts = generateShifts($b);
        
        // Pad stops to at least 6
        $stops = $route['stops'];
        while (count($stops) < 6) {
            $stops[] = $stops[count($stops) - 1] . ' Junction';
        }
        // Ensure exactly 9 slots (fill remaining with NULL)
        while (count($stops) < 9) {
            $stops[] = null;
        }

        $routeName = $db->real_escape_string($route['route']);
        $busNumEsc = $db->real_escape_string($busNum);
        $distEsc = $db->real_escape_string($distName);

        $stopVals = [];
        for ($s = 0; $s < 9; $s++) {
            $stopVals[] = $stops[$s] !== null ? "'" . $db->real_escape_string($stops[$s]) . "'" : "NULL";
        }

        $batchValues[] = "($inchargeId, '$busNumEsc', '$routeName', 'Route Bus', '$distEsc', " .
            "'{$shifts[0]}', '{$shifts[1]}', '{$shifts[2]}', '{$shifts[3]}', NULL, NULL, " .
            implode(', ', $stopVals) . ")";

        if (count($batchValues) >= $batchSize || $b === 699) {
            $sql = "INSERT INTO buses (incharge_id, bus_number, route, bus_type, district, " .
                "shift1_time, shift2_time, shift3_time, shift4_time, shift5_time, shift6_time, " .
                "stop1, stop2, stop3, stop4, stop5, stop6, stop7, stop8, stop9) VALUES \n" .
                implode(",\n", $batchValues);
            
            try {
                if ($db->query($sql)) {
                    $inserted = $db->affected_rows;
                    $distBusCount += $inserted;
                    $totalInserted += $inserted;
                }
            } catch (Exception $e) {
                echo "  BATCH ERROR at bus $b, trying individual inserts...\n";
                foreach ($batchValues as $val) {
                    try {
                        $singleSql = "INSERT INTO buses (incharge_id, bus_number, route, bus_type, district, " .
                            "shift1_time, shift2_time, shift3_time, shift4_time, shift5_time, shift6_time, " .
                            "stop1, stop2, stop3, stop4, stop5, stop6, stop7, stop8, stop9) VALUES $val";
                        if ($db->query($singleSql)) {
                            $distBusCount++;
                            $totalInserted++;
                        }
                    } catch (Exception $e2) {
                        // Skip duplicates silently
                    }
                }
            }
            $batchValues = [];
        }
    }
    
    echo "  => $distBusCount buses inserted for $distName\n";
    flush();
}

echo "\n========================================\n";
echo "TOTAL BUSES INSERTED: $totalInserted\n";
echo "========================================\n";

// Verification queries
echo "\n--- VERIFICATION ---\n";
$result = $db->query("SELECT COUNT(*) as cnt FROM buses WHERE bus_type = 'Route Bus'");
$row = $result->fetch_assoc();
echo "Total Route Buses: " . $row['cnt'] . "\n";

$result = $db->query("SELECT district, COUNT(*) as cnt FROM buses WHERE bus_type = 'Route Bus' GROUP BY district ORDER BY district");
while ($row = $result->fetch_assoc()) {
    echo "  {$row['district']}: {$row['cnt']} buses\n";
}

echo "\n--- SAMPLE DATA (first 5 buses) ---\n";
$result = $db->query("SELECT bus_number, route, district, stop1, stop2, stop3, stop4, stop5, stop6 FROM buses LIMIT 5");
while ($row = $result->fetch_assoc()) {
    echo "  [{$row['bus_number']}] {$row['route']} ({$row['district']}) => {$row['stop1']} > {$row['stop2']} > {$row['stop3']} > {$row['stop4']} > {$row['stop5']} > {$row['stop6']}\n";
}

$db->close();
echo "\n</pre><h3 style='color:green'>✅ Seeding Complete!</h3>";
echo "<p><a href='platform_incharge_login.php'>Go to Login</a> | <a href='index.php'>Go to Home</a></p>";
?>
