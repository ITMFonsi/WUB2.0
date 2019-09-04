class Invoice {
    constructor(id, invoiceCustomer, invoiceDate, invoiceDueDate, invoiceItems, invoiceNumber, invoiceOpen, invoiceSumPaid, invoiceTaxSum, invoiceTotal, invoiceTotalBeforeTax) {
        this.id = id;
        this.invoiceCustomer = invoiceCustomer,
        this.invoiceDate = invoiceDate,
        this.invoiceDueDate = invoiceDueDate,
        this.invoiceItems = invoiceItems,
        this.invoiceNumber = invoiceNumber,
        this.invoiceOpen = invoiceOpen,
        this.invoiceSumPaid = invoiceSumPaid,
        this.invoiceTaxSum = invoiceTaxSum,
        this.invoiceTotal = invoiceTotal,
        this.invoiceTotalBeforeTax = invoiceTotalBeforeTax
    }

    setId(newId) { return this.id = newId }
    getId() { return this.id; }

    getInvoiceCustomer() { return this.invoiceCustomer; }
    setInvoiceCustomer(invoiceCustomer) { return this.invoiceCustomer = invoiceCustomer; }

    getInvoiceDate() { return this.invoiceDate; }
    setInvoiceDate(invoiceDate) { return this.invoiceDate = invoiceDate; }

    getInvoiceDueDate() { return this.invoiceDueDate; }
    setInvoiceDueDate(invoiceDueDate) { return this.invoiceDueDate = invoiceDueDate; }

    getInvoiceItems() { return this.invoiceItems; }
    setInvoiceItems(invoiceItems) { return this.invoiceItems = invoiceItems; }

    getInvoiceNumber() { return this.invoiceNumber; }
    setInvoiceNumber(invoiceNumber) { return this.invoiceNumber = invoiceNumber; }

    getInvoiceOpen() { return this.invoiceOpen; }
    setInvoiceOpen(invoiceOpen) { return this.invoiceOpen = invoiceOpen; }

    getInvoiceSumPaid() { return this.invoiceSumPaid; }
    setInvoiceSumPaid(invoiceSumPaid) { return this.invoiceSumPaid = invoiceSumPaid; }

    getInvoiceTaxSum() { return this.invoiceTaxSum; }
    setInvoiceTaxSum(invoiceTaxSum) { return this.invoiceTaxSum = invoiceTaxSum; }

    getInvoiceTotal() { return this.invoiceTotal; }
    setInvoiceTotal(invoiceTotal) { return this.invoiceTotal = invoiceTotal; }

    getInvoiceTotalBeforeTax() { return this.invoiceTotalBeforeTax; }
    setInvoiceTotalBeforeTax(invoiceTotalBeforeTax) { return this.invoiceTotalBeforeTax = invoiceTotalBeforeTax; }

}
export default Invoice