import firebase from 'firebase'
import Invoice from '../models/Invoice'

let DBInvoices = {
    getAllInvoices: function() {
        var db = firebase.firestore();
        var invoices = [];

        db.collection("invoices").get().then(function(querySnapshot) {
            querySnapshot.forEach(function(doc) {
                var invoice = new Invoice();
                invoice.setId(doc.id);
                invoice.setInvoiceCustomer(doc.data().invoiceCustomer);
                invoice.setInvoiceNumber(doc.data().invoiceNumber);
                invoice.setInvoiceDate(doc.data().invoiceDate);
                invoice.setInvoiceDueDate(doc.data().invoiceDate);
                invoice.setInvoiceOpen(doc.data().invoiceOpen);
                invoice.setInvoiceItems(doc.data().invoiceItems);
                invoice.setInvoiceTotalBeforeTax(doc.data().invoiceTotalBeforeTax);
                invoice.setInvoiceTaxSum(doc.data().invoiceTaxSum);
                invoice.setInvoiceTotal(doc.data().invoiceTotal);
                invoice.setInvoiceSumPaid(doc.data().invoiceSumPaid);
            
                invoices.push(invoice);
            });
        });
        return invoices;
    },

    addInvoice: async function (customer, newInvoiceDetails, newInvoiceItems) {
        var db = firebase.firestore();
        var invoicesRef = db.collection("invoices");

        invoicesRef.add({
            invoiceCustomer: {
                id: customer.id,
                name: customer.name,
                mail: customer.mail,
                phone1: customer.phone1,
                address: customer.address,
                city: customer.city,
                zip: customer.zip,
                country: customer.country
            },
            invoiceNumber: newInvoiceDetails.invoiceNumber,
            invoiceDate: newInvoiceDetails.invoiceDate,
            invoiceDueDate: newInvoiceDetails.invoiceDueDate,
            invoiceOpen: newInvoiceDetails.invoiceOpen,
            invoiceItems: newInvoiceItems,
            invoiceTotalBeforeTax: newInvoiceDetails.invoiceTotalBeforeTax,
            invoiceTaxSum: newInvoiceDetails.invoiceTaxSum,
            invoiceTotal: newInvoiceDetails.invoiceTotal,
            invoiceSumPaid: {},
        })
        .then(function(docRef) {
            return true;
        })
        .catch(function(error) {
            return false;
        });
        
    },

    updatePaymentSum: async function (item, newPayment) {
        var db = firebase.firestore();
        var invoicesRef = db.collection("invoices").doc(item.id);

        await invoicesRef.update({
            invoiceCustomer: {
                id: item.invoiceCustomer.id,
                name:  item.invoiceCustomer.name,
                mail:  item.invoiceCustomer.mail,
                phone1:  item.invoiceCustomer.phone1,
                address:  item.invoiceCustomer.address,
                city:  item.invoiceCustomer.city,
                zip:  item.invoiceCustomer.zip,
                country:  item.invoiceCustomer.country
            },
            invoiceNumber: item.invoiceNumber,
            invoiceDate:  item.invoiceDate,
            invoiceDueDate:  item.invoiceDueDate,
            invoiceOpen:  item.invoiceOpen,
            invoiceItems:  item.invoiceItems,
            invoiceTotalBeforeTax:  item.invoiceTotalBeforeTax,
            invoiceTaxSum:  item.invoiceTaxSum,
            invoiceTotal:  item.invoiceTotal,
            invoiceSumPaid: firebase.firestore.FieldValue.arrayUnion(newPayment)
        })
        .then(function(docRef) {
            return true;
        })
        .catch(function(error) {
            return false;
        });
    },

    getNextInvoiceNumber: async function() {
        var db = firebase.firestore();
        var invoices = [];
        var invoiceNumber;
    
        await db.collection("invoices").get().then(function(querySnapshot) {
            querySnapshot.forEach(function(doc) {
                invoices.push(doc.data());
            });
    
          // get highest id and increment
          var newID = 0;
          invoices.map(function(obj){     
            if (obj.invoiceNumber > newID) newID = obj.invoiceNumber;    
          });
          invoiceNumber = (parseFloat(newID) + 1);
        });
        return invoiceNumber;
    },

    updateInvoice: async function (toEdit) {
        
    },

    deleteInvoice: async function (toDelete) {
        var db = firebase.firestore();
        await db.collection("invoices").doc(toDelete.id).delete().then(function() {
            return true;
        }).catch(function(error) {
            return false;
        });
    },
}
export default DBInvoices

