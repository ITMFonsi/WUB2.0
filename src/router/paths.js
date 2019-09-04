/**
 * Define all of your application routes here
 * for more information on routes, see the
 * official documentation https://router.vuejs.org/en/
 */
export default [
  {
    path: '/dashboard',
    // Relative to /src/views
    view: 'Dashboard'
  },
  {
    path: '/customers',
    name: 'Customers',
    view: 'Customers',
  },
  {
    path: '/products',
    name: 'Products',
    view: 'Products',
  },
  {
    path: '/invoices',
    name: 'Invoices',
    view: 'InvoiceList',
  },
  {
    path: '/newinvoice',
    name: 'Invoices',
    view: 'Invoices',
  }
]
