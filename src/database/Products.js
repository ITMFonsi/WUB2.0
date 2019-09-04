import firebase from 'firebase'
import Product from '../models/Product'

let DBProducts = {
    getAllProducts: function() {
        var db = firebase.firestore();
        var products = [];
    
        db.collection("products").get().then(function(querySnapshot) {
            querySnapshot.forEach(function(doc) {
                var product = new Product();
                product.setId(doc.id)
                product.setProduct_nr(doc.data().product_nr)
                product.setName(doc.data().name)
                product.setDescription(doc.data().description)
                product.setPrice(doc.data().price)
                product.setPriceGross(doc.data().priceGross)
                product.setTaxPercentage(doc.data().taxPercentage)
                product.setInStock(doc.data().inStock)

                products.push(product);
            });
        });
        return products;
      },

    addProduct: async function (newProduct) {
        var db = firebase.firestore();
        var productsRef = db.collection("products");
    
        productsRef.add({
            product_nr: newProduct.product_nr,
            name: newProduct.name,
            description: newProduct.description,
            price: newProduct.price,
            priceGross: newProduct.priceGross,
            taxPercentage: newProduct.taxPercentage,
            inStock: newProduct.inStock
        })
        .then(function(docRef) {
          return true;
        })
        .catch(function(error) {
          return false;
        });
      },

    updateProduct: async function (toEdit) {
        var db = firebase.firestore();
        var productsRef = db.collection("products").doc(toEdit.id);
    
        productsRef.set({
            product_nr: toEdit.product_nr,
            name: toEdit.name,
            description: toEdit.description,
            price: toEdit.price,
            priceGross: toEdit.priceGross,
            taxPercentage: toEdit.taxPercentage,
            inStock: toEdit.inStock
        })
        .then(function(docRef) {
            return true;
        })
        .catch(function(error) {
            return false;
        });
      },

      deleteProduct: async function (toDelete) {
        var me = this;
        var db = firebase.firestore();
    
        db.collection("products").doc(toDelete.id).delete().then(function() {
            return true;
        }).catch(function(error) {
            return false;
        });
      },
}
export default DBProducts

