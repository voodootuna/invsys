# Equipment Tracker - Mobile-First UI Design Specification

## Design Philosophy

A **professional, clean, and highly functional** mobile-first design that prioritizes usability for field workers and equipment managers. The design balances industrial robustness with modern mobile app conventions.

---

## Color Palette

### Primary Colors
```css
--primary-blue: #2563EB;        /* Main brand color - buttons, links */
--primary-dark: #1D4ED8;        /* Pressed states, emphasis */
--primary-light: #60A5FA;       /* Hover states, secondary elements */
--primary-subtle: #DBEAFE;      /* Background highlights */
```

### Status Colors
```css
--status-available: #059669;    /* Green - equipment available */
--status-rented: #DC2626;       /* Red - equipment in use */
--status-broken: #D97706;       /* Orange - equipment broken */
--status-maintenance: #6B7280;  /* Gray - under maintenance */
```

### Neutral Palette
```css
--gray-50: #F9FAFB;             /* App background */
--gray-100: #F3F4F6;            /* Card backgrounds */
--gray-200: #E5E7EB;            /* Borders, dividers */
--gray-300: #D1D5DB;            /* Disabled elements */
--gray-500: #6B7280;            /* Secondary text */
--gray-700: #374151;            /* Primary text */
--gray-900: #111827;            /* Headers, emphasis */
--white: #FFFFFF;               /* Pure white elements */
```

### Semantic Colors
```css
--success: #10B981;             /* Success messages */
--warning: #F59E0B;             /* Warnings */
--error: #EF4444;               /* Errors, destructive actions */
--info: #3B82F6;                /* Information, neutral actions */
```

---

## Typography

### Font Stack
```css
font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
```

### Type Scale (Mobile-Optimized)
```css
--text-xs: 12px;      /* Fine print, metadata */
--text-sm: 14px;      /* Secondary text, labels */
--text-base: 16px;    /* Body text, forms */
--text-lg: 18px;      /* Equipment names, important info */
--text-xl: 20px;      /* Section headers */
--text-2xl: 24px;     /* Page titles */
--text-3xl: 30px;     /* App title, hero elements */
```

### Font Weights
```css
--font-normal: 400;   /* Body text */
--font-medium: 500;   /* Labels, secondary headers */
--font-semibold: 600; /* Equipment names, buttons */
--font-bold: 700;     /* Page headers, emphasis */
```

### Line Heights
```css
--leading-tight: 1.25;    /* Headers, tight layouts */
--leading-normal: 1.5;    /* Body text */
--leading-relaxed: 1.625; /* Longer text blocks */
```

---

## Spacing System

### Base Unit: 4px
```css
--space-1: 4px;       /* 1 unit - tight spacing */
--space-2: 8px;       /* 2 units - small gaps */
--space-3: 12px;      /* 3 units - standard spacing */
--space-4: 16px;      /* 4 units - section gaps */
--space-5: 20px;      /* 5 units - large spacing */
--space-6: 24px;      /* 6 units - major sections */
--space-8: 32px;      /* 8 units - page sections */
--space-12: 48px;     /* 12 units - major breaks */
```

### Container Spacing
```css
--container-padding: 16px;    /* Mobile container padding */
--container-sm: 20px;         /* Small screens */
--container-lg: 24px;         /* Large screens */
```

---

## Layout & Grid

### Mobile-First Containers
```css
/* Full-width mobile container */
.app-container {
  width: 100%;
  min-height: 100vh;
  padding: 0 var(--container-padding);
  background: var(--gray-50);
}

/* Content sections */
.content-section {
  margin-bottom: var(--space-6);
}

/* Safe area for iOS */
.safe-area {
  padding-top: env(safe-area-inset-top);
  padding-bottom: env(safe-area-inset-bottom);
}
```

### Equipment Grid
```css
.equipment-grid {
  display: grid;
  gap: var(--space-4);
  grid-template-columns: repeat(2, 1fr);  /* 2 columns mobile */
}

@media (min-width: 480px) {
  .equipment-grid {
    grid-template-columns: repeat(3, 1fr); /* 3 columns larger mobile */
  }
}

@media (min-width: 768px) {
  .equipment-grid {
    grid-template-columns: repeat(4, 1fr); /* 4 columns tablet */
  }
}
```

---

## Components

### App Header
```css
.app-header {
  background: var(--white);
  border-bottom: 1px solid var(--gray-200);
  padding: var(--space-4) var(--container-padding);
  min-height: 60px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.app-title {
  font-size: var(--text-xl);
  font-weight: var(--font-semibold);
  color: var(--gray-900);
}

.user-welcome {
  font-size: var(--text-sm);
  color: var(--gray-500);
}
```

### Status Stats Row
```css
.stats-row {
  display: flex;
  gap: var(--space-3);
  overflow-x: auto;
  padding: var(--space-2) 0;
  margin: 0 calc(-1 * var(--container-padding));
  padding-left: var(--container-padding);
  padding-right: var(--container-padding);
}

.stat-card {
  background: var(--white);
  border-radius: 12px;
  padding: var(--space-3) var(--space-4);
  min-width: 100px;
  text-align: center;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  flex-shrink: 0;
}

.stat-number {
  font-size: var(--text-2xl);
  font-weight: var(--font-bold);
  line-height: var(--leading-tight);
}

.stat-label {
  font-size: var(--text-xs);
  font-weight: var(--font-medium);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  color: var(--gray-500);
  margin-top: var(--space-1);
}
```

### Equipment Cards (Industrial/Professional Style)
```css
.equipment-card {
  background: var(--white);
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: all 0.2s ease;
  border: 1px solid var(--gray-200);
  min-height: 120px;
  display: flex;
  align-items: flex-start;
  padding: var(--space-4);
  gap: var(--space-4);
  position: relative;
}

.equipment-card:active {
  transform: scale(0.98);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.equipment-photo-container {
  flex-shrink: 0;
  width: 60px;
  height: 60px;
  position: relative;
}

.equipment-photo {
  width: 100%;
  height: 100%;
  border-radius: 8px;
  object-fit: cover;
  border: 1px solid var(--gray-200);
}

.equipment-photo-placeholder {
  width: 100%;
  height: 100%;
  border-radius: 8px;
  background: var(--gray-100);
  border: 1px solid var(--gray-200);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: var(--gray-400);
}

.equipment-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-width: 0;
}

.equipment-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: var(--space-2);
}

.equipment-name {
  font-size: var(--text-base);
  font-weight: var(--font-semibold);
  color: var(--gray-900);
  line-height: var(--leading-tight);
  margin: 0;
  margin-right: var(--space-2);
}

.status-indicator {
  flex-shrink: 0;
  padding: var(--space-1) var(--space-2);
  border-radius: 6px;
  font-size: var(--text-xs);
  font-weight: var(--font-semibold);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  line-height: 1;
}

.status-indicator.available {
  background: var(--status-available);
  color: white;
}

.status-indicator.rented {
  background: var(--status-rented);
  color: white;
}

.status-indicator.broken {
  background: var(--status-broken);
  color: white;
}

.status-indicator.maintenance {
  background: var(--status-maintenance);
  color: white;
}

.equipment-meta {
  display: flex;
  flex-direction: column;
  gap: var(--space-1);
}

.equipment-type {
  font-size: var(--text-sm);
  color: var(--gray-600);
  font-weight: var(--font-medium);
  text-transform: capitalize;
  margin: 0;
}

.equipment-location {
  font-size: var(--text-sm);
  color: var(--gray-500);
  margin: 0;
  display: flex;
  align-items: center;
  gap: var(--space-1);
}

.location-icon {
  font-size: var(--text-xs);
  opacity: 0.7;
}
```

### Buttons
```css
.btn {
  font-weight: var(--font-semibold);
  border-radius: 12px;
  transition: all 0.2s ease;
  border: none;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-height: 44px; /* iOS touch target minimum */
  font-size: var(--text-base);
}

.btn-primary {
  background: var(--primary-blue);
  color: var(--white);
  padding: var(--space-3) var(--space-5);
}

.btn-primary:hover {
  background: var(--primary-dark);
}

.btn-primary:active {
  background: var(--primary-dark);
  transform: scale(0.98);
}

.btn-large {
  padding: var(--space-4) var(--space-6);
  font-size: var(--text-lg);
  min-height: 56px;
}

.btn-full {
  width: 100%;
}
```

### Forms
```css
.form-input {
  background: var(--white);
  border: 2px solid var(--gray-200);
  border-radius: 12px;
  padding: var(--space-3) var(--space-4);
  font-size: var(--text-base);
  min-height: 44px;
  width: 100%;
  transition: border-color 0.2s ease;
}

.form-input:focus {
  outline: none;
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 3px var(--primary-subtle);
}

.form-label {
  font-size: var(--text-sm);
  font-weight: var(--font-medium);
  color: var(--gray-700);
  margin-bottom: var(--space-2);
  display: block;
}

.form-group {
  margin-bottom: var(--space-5);
}
```

### Status Indicators
```css
.status-available .status-dot { background: var(--status-available); }
.status-rented .status-dot { background: var(--status-rented); }
.status-broken .status-dot { background: var(--status-broken); }
.status-maintenance .status-dot { background: var(--status-maintenance); }

.status-available .status-label { color: var(--status-available); }
.status-rented .status-label { color: var(--status-rented); }
.status-broken .status-label { color: var(--status-broken); }
.status-maintenance .status-label { color: var(--status-maintenance); }
```

---

## Interaction Design

### Touch Targets
- **Minimum size**: 44x44px (iOS guidelines)
- **Recommended size**: 48x48px
- **Spacing**: 8px minimum between touch targets

### Animations
```css
/* Standard transitions */
.transition-standard { transition: all 0.2s ease; }
.transition-fast { transition: all 0.15s ease; }
.transition-slow { transition: all 0.3s ease; }

/* Touch feedback */
.touch-feedback:active {
  transform: scale(0.98);
  transition: transform 0.1s ease;
}

/* Loading states */
.loading {
  opacity: 0.6;
  pointer-events: none;
}
```

### States
```css
/* Hover (desktop) */
@media (hover: hover) {
  .equipment-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
  }
}

/* Focus (accessibility) */
.equipment-card:focus {
  outline: 3px solid var(--primary-blue);
  outline-offset: 2px;
}

/* Active (touch) */
.equipment-card:active {
  transform: scale(0.98);
}
```

---

## French Localization

### Status Labels
```
- available → "LIBRE"
- rented → "PRIS" 
- broken → "EN PANNE"
- maintenance → "MAINTENANCE"
```

### Common Interface Text
```
- "Équipements disponibles" (Available Equipment)
- "Prendre un outil" (Take Equipment)
- "Retourner l'outil" (Return Equipment)
- "Rechercher..." (Search...)
- "Bienvenue" (Welcome)
```

---

## Accessibility

### WCAG Compliance
- **Color contrast**: 4.5:1 minimum for normal text, 3:1 for large text
- **Focus indicators**: Visible 3px outline for keyboard navigation  
- **Touch targets**: 44px minimum per Apple/Android guidelines
- **Screen reader**: Proper ARIA labels and semantic HTML

### Implementation
```css
/* Focus indicators */
.focus-ring:focus {
  outline: 3px solid var(--primary-blue);
  outline-offset: 2px;
}

/* High contrast mode support */
@media (prefers-contrast: high) {
  .equipment-card {
    border: 2px solid var(--gray-300);
  }
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
  * {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
```

---

## Implementation Notes

1. **Mobile-first approach**: All designs start with mobile and scale up
2. **Touch-optimized**: All interactive elements meet touch target requirements
3. **Performance**: Optimized for slower mobile connections
4. **Progressive enhancement**: Works without JavaScript
5. **Cross-platform**: Consistent experience across iOS/Android/desktop

This design system creates a **professional, modern, mobile-first application** that feels native while maintaining the robust functionality needed for equipment management.