import firebase from 'firebase'
import Customer from '../models/Customer'
import Invoice from '../models/Invoice'

let DBCustomers = {
    getAllCustomers: function() {
        var db = firebase.firestore();
        var customers = [];

        db.collection("customers").get().then(function(querySnapshot) {
            querySnapshot.forEach(function(doc) {
                var customer = new Customer();
                customer.setId(doc.id)
                customer.setName(doc.data().name)
                customer.setMail(doc.data().mail)
                customer.setPhone1(doc.data().phone1)
                customer.setAddress(doc.data().address)
                customer.setCity(doc.data().city)
                customer.setZip(doc.data().zip)
                customer.setCountry(doc.data().country)
                customer.setComments(doc.data().comments)

                customers.push(customer);
            });
        });
        return customers;
    },
    addCustomer: async function (newCustomer) {
        var db = firebase.firestore();
        var customersRef = db.collection("customers");

        customersRef.add({
            name: newCustomer.name,
            mail: newCustomer.mail,
            phone1: newCustomer.phone1,
            address: newCustomer.address,
            city: newCustomer.city,
            zip: newCustomer.zip,
            country: newCustomer.country,
            comments: newCustomer.comments
        })
        .then(function(docRef) {
            return true;
        })
        .catch(function(error) {
            return false;
        });
        
    },
    updateCustomer: async function (toEdit) {
        var db = firebase.firestore();
        var customersRef = db.collection("customers").doc(toEdit.id);

        customersRef.set({
            name: toEdit.name,
            mail: toEdit.mail,
            phone1: toEdit.phone1,
            address: toEdit.address,
            city: toEdit.city,
            zip: toEdit.zip,
            country: toEdit.country,
            comments: toEdit.comments
        })
        .then(function(docRef) {
            return true;
        })
        .catch(function(error) {
            return false;
        });
    },
    deleteCustomer: async function (toDelete) {
        var db = firebase.firestore();
        db.collection("customers").doc(toDelete.id).delete().then(function() {
            return true;
        }).catch(function(error) {
            return false;
        });
    },
    getInvoiceForCustomer: function(item) {
    var db = firebase.firestore();
    var invoices = [];

    db.collection("invoices").where('invoiceCustomer.id', '==', item.id).get().then(function(querySnapshot) {
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
    }
}
export default DBCustomers

