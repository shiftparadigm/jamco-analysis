<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Tailwind CSS - Load First -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Public Sans', 'sans-serif'],
                    },
                    colors: {
                        farmers: {
                            navy: '#003D7C',
                            red: '#E63026',
                            blue: '#0070B8',
                            gray: '#F4F4F4',
                        },
                        navy: '#003D7C',
                    },
                }
            }
        }
    </script>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-slate-50 text-slate-700 antialiased'); ?>>
<?php wp_body_open(); ?>

<!-- NAVIGATION -->
<nav class="bg-white border-b border-slate-200 fixed w-full z-50 top-0 shadow-sm">
    <div class="container mx-auto px-6 h-20 flex justify-between items-center">
        <!-- Logo Area -->
        <div class="flex items-center space-x-3">
            <div class="bg-farmers-red w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-md">
                F
            </div>
            <div>
                <span class="block text-farmers-navy font-bold text-lg leading-none">FARMERS</span>
                <span class="block text-slate-400 text-xs tracking-wider font-semibold uppercase">Device Protection</span>
            </div>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
            <a href="#coverage" class="hover:text-farmers-red transition">Coverage</a>
            <a href="#how-it-works" class="hover:text-farmers-red transition">How it Works</a>
            <a href="#pricing" class="hover:text-farmers-red transition">Pricing</a>
            <a href="#faq" class="hover:text-farmers-red transition">FAQs</a>
        </div>

        <!-- CTA -->
        <div class="flex items-center space-x-4">
            <a href="#" class="hidden md:block text-farmers-navy font-semibold hover:underline">Track Claim</a>
            <a href="#" class="bg-farmers-red hover:bg-red-700 text-white px-6 py-2.5 rounded-full font-bold shadow-lg shadow-red-200 transition transform hover:-translate-y-0.5">
                File a Claim
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-slate-600 hover:text-farmers-red" id="mobile-menu-button">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </div>
</nav>

<!-- Add top padding to account for fixed nav -->
<div class="pt-20">

<?php
// Main content loop
if (have_posts()) :
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
else :
    ?>
    <div class="container mx-auto px-6 py-16 text-center">
        <h1 class="text-3xl font-bold"><?php _e('No Content Found', 'likewize'); ?></h1>
        <p class="text-slate-600 mt-4"><?php _e('Please add blocks to this page in the WordPress editor.', 'likewize'); ?></p>
    </div>
    <?php
endif;
?>

</div>

<!-- FOOTER -->
<footer class="bg-farmers-navy text-slate-300 py-12 text-sm">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8 mb-8 border-b border-blue-800 pb-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="bg-white text-farmers-red w-8 h-8 rounded flex items-center justify-center font-bold">F</div>
                    <span class="text-white font-bold text-lg">FARMERS</span>
                </div>
                <p class="max-w-xs text-blue-200">
                    Device Protection is administered by Likewize Agency, LLC. Farmers Insurance® and the Farmers logo are trademarks of Farmers Insurance Exchange.
                </p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white transition">File a Claim</a></li>
                    <li><a href="#" class="hover:text-white transition">Track a Claim</a></li>
                    <li><a href="#" class="hover:text-white transition">Program Brochure</a></li>
                    <li><a href="#" class="hover:text-white transition">Terms & Conditions</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Contact Support</h4>
                <ul class="space-y-2">
                    <li class="flex items-center"><i data-lucide="phone" class="w-4 h-4 mr-2"></i> 1-800-555-0199</li>
                    <li class="flex items-center"><i data-lucide="mail" class="w-4 h-4 mr-2"></i> help@likewize.com</li>
                    <li class="mt-4 text-xs text-blue-400">Mon-Fri: 8am - 9pm EST<br>Sat-Sun: 9am - 6pm EST</li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-between items-center text-xs text-blue-400">
            <p>&copy; 2024 Likewize. All rights reserved.</p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">California Privacy Rights</a>
                <a href="#" class="hover:text-white">Accessibility</a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
