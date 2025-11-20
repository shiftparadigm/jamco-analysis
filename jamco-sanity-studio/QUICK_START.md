# Quick Start - Next Steps

Dependencies are installed! Now you need to initialize your Sanity project.

## Step 1: Initialize Sanity Project

Run this command and follow the prompts:

```bash
npx sanity init
```

You'll be asked to:
1. **Login/Sign up** - Use your Sanity account (or create one)
2. **Create new project** - Answer "Yes"
3. **Project name** - e.g., "Jamco America"
4. **Use default dataset** - Answer "Yes" (or name it "production")
5. **Output path** - Press Enter to use current directory

This will:
- Create a Sanity project in the cloud
- Add your project ID to `sanity.config.ts`
- Set up authentication

## Step 2: Update Environment Variables

After init completes, update `.env` with your actual project ID:

```env
SANITY_STUDIO_PROJECT_ID=abc123xyz  # Your actual project ID
SANITY_STUDIO_DATASET=production
```

## Step 3: Start Development Server

```bash
npm run dev
```

Visit **http://localhost:3333**

## What's Ready

✅ All dependencies installed (1282 packages)
✅ Complete schema with 5 document types
✅ 9 content blocks ready to use
✅ Bilingual support (English/Japanese)
✅ Custom desk structure
✅ SEO fields on all content

## Running in Background

To run in background while you do other work:

```bash
# Start in background
npm run dev &

# Or use screen/tmux
screen -S sanity
npm run dev
# Press Ctrl+A, then D to detach
```

## Troubleshooting

**If you already have a Sanity account and project:**
- Get your project ID from https://sanity.io/manage
- Update `sanity.config.ts` with your project ID
- Update `.env` with your project ID
- Skip `sanity init` and go straight to `npm run dev`

**Need to change project later:**
- Edit `sanity.config.ts` and update the `projectId`
- Update `.env` as well
