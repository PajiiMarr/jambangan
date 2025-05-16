module.exports = {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./app/View/Components/**/*.php",
        "./vendor/livewire-ui/modal/tailwind.config.js"
    ],
    theme: {
        extend: {
            // ... existing theme extensions
        }
    },
    variants: {
        extend: {
            // ... existing variants
        }
    },
    plugins: [
        // ... existing plugins
    ],
    // Add a global dark mode style for labels
    safelist: [
        {
            pattern: /^(text-)/,
            variants: ['dark']
        }
    ]
}; 