import { chromium } from 'playwright';

const SITE_URL = 'https://blue-island-0b5fa6310.3.azurestaticapps.net/premium-seating';

async function captureScreenshots() {
  const browser = await chromium.launch();
  const page = await browser.newPage({
    viewport: { width: 1440, height: 900 }
  });

  await page.goto(SITE_URL, { waitUntil: 'networkidle' });

  // Wait for images to load
  await page.waitForTimeout(2000);

  // Capture full page screenshot
  await page.screenshot({
    path: 'screenshots/full-page.png',
    fullPage: true
  });

  // Capture viewport sections for comparison
  const sections = [
    { name: 'hero', y: 0 },
    { name: 'section-2', y: 900 },
    { name: 'section-3', y: 1800 },
    { name: 'section-4', y: 2700 },
    { name: 'section-5', y: 3600 },
  ];

  for (const section of sections) {
    await page.evaluate((y) => window.scrollTo(0, y), section.y);
    await page.waitForTimeout(500);
    await page.screenshot({
      path: `screenshots/${section.name}.png`,
    });
  }

  await browser.close();
  console.log('Screenshots captured in ./screenshots/');
}

captureScreenshots().catch(console.error);
