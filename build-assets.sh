#!/bin/bash
echo "Building assets for production..."

# Install Node dependencies
npm ci --no-audit

# Build for production
npm run build

# Build Docker image
docker build -t atelier-veridique .

echo "Build complete!"