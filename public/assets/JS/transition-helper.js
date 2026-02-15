/**
 * Quick Script to Add Page Transitions to All Portal Pages
 * Run this in browser console or add as an include to apply globally
 */

// Files that need the transition script
const filesToUpdate = [
    'passenger_login.php',
    'platform_incharge_login.php',
    'add_bus.php',
    'delete_bus.php',
    'fetch_all_buses.php',
    'bus_details.php'
];

// Add this snippet before </body> tag:
const transitionSnippet = `
    <!-- Page Transitions -->
    <script src="assets/js/page-transitions.js"></script>
`;

console.log('Add the following snippet before </body> in these files:');
console.log(filesToUpdate.join('\n'));
console.log('\nSnippet:');
console.log(transitionSnippet);
