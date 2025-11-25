import { chromium } from 'playwright';

const SITE_URL = 'http://localhost:4321/premium-seating';

async function captureMobile() {
  const browser = await chromium.launch();
  const page = await browser.newPage({
    viewport: { width: 390, height: 844 } // iPhone 14 Pro
  });

  await page.goto(SITE_URL, { waitUntil: 'networkidle' });
  await page.waitForTimeout(2000);

  await page.screenshot({
    path: 'screenshots/mobile-full.png',
    fullPage: true
  });

  // Capture specific sections
  const sections = [
    { name: 'mobile-hero', y: 0 },
    { name: 'mobile-section-2', y: 844 },
    { name: 'mobile-section-3', y: 1688 },
    { name: 'mobile-section-4', y: 2532 },
  ];

  for (const section of sections) {
    await page.evaluate((y) => window.scrollTo(0, y), section.y);
    await page.waitForTimeout(300);
    await page.screenshot({
      path: `screenshots/${section.name}.png`,
    });
  }

  await browser.close();
  console.log('Mobile screenshots captured');
}

captureMobile().catch(console.error);
