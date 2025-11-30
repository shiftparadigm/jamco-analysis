const { chromium } = require('playwright');
const path = require('path');

(async () => {
  const browser = await chromium.launch();
  const context = await browser.newContext({
    viewport: { width: 1440, height: 900 }
  });

  // Screenshot WordPress site
  console.log('Capturing WordPress site...');
  const wpPage = await context.newPage();
  await wpPage.goto('http://localhost:8888/', { waitUntil: 'networkidle' });
  await wpPage.waitForTimeout(2000);
  await wpPage.screenshot({
    path: '/home/tony/projects/jamco-analysis/jamco-wordpress/screenshots/wordpress-full.png',
    fullPage: true
  });

  // Screenshot Astro site
  console.log('Capturing Astro site...');
  const astroPage = await context.newPage();
  await astroPage.goto('https://blue-island-0b5fa6310.3.azurestaticapps.net/premium-seating', { waitUntil: 'networkidle' });
  await astroPage.waitForTimeout(2000);
  await astroPage.screenshot({
    path: '/home/tony/projects/jamco-analysis/jamco-wordpress/screenshots/astro-full.png',
    fullPage: true
  });

  console.log('Screenshots saved!');
  await browser.close();
})();
