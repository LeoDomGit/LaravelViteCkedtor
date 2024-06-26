import React, { useEffect } from 'react';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { ProSidebarProvider } from 'react-pro-sidebar';
import axios from 'axios';
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js"; // Ensure Bootstrap JS bundle is used

// Utility to get the CSRF token from the meta tag
const getCsrfToken = () => {
  const token = document.querySelector('meta[name="csrf-token"]');
  return token && token.getAttribute('content');
};
axios.defaults.headers.common['X-CSRF-TOKEN'] = getCsrfToken();

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true });
    return pages[`./Pages/${name}.jsx`];
  },
  setup({ el, App, props }) {
    const root = createRoot(el);
    root.render(
      <ProSidebarProvider>
        <App {...props} />
      </ProSidebarProvider>
    );
  },
});
