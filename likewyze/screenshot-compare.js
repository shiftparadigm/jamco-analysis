const { chromium } = require('playwright');
const path = require('path');

(async () => {
  const browser = await chromium.launch();
  const context = await browser.newContext({
    viewport: { width: 1920, height: 1080 }
  });

  // Screenshot 1: Reference HTML page
  console.log('Taking screenshot of reference page...');
  const page1 = await context.newPage();
  await page1.goto(`file://${path.resolve(__dirname, 'test-page.html')}`);
  await page1.waitForTimeout(2000); // Wait for fonts/images
  await page1.screenshot({
    path: '/home/tony/Pictures/likewyze-reference.png',
    fullPage: true
  });
  console.log('✓ Reference screenshot saved to ~/Pictures/likewyze-reference.png');

  // Screenshot 2: WordPress implementation
  console.log('Taking screenshot of WordPress page...');
  const page2 = await context.newPage();
  await page2.goto('http://localhost:8889');
  await page2.waitForTimeout(2000); // Wait for fonts/images
  await page2.screenshot({
    path: '/home/tony/Pictures/likewyze-wordpress.png',
    fullPage: true
  });
  console.log('✓ WordPress screenshot saved to ~/Pictures/likewyze-wordpress.png');

  await browser.close();
  console.log('\n✓ Screenshots complete!');
})();
