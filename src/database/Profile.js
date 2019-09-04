import firebase from 'firebase'

let DBProfile = {
    getInvoicerDetails: async function() {
        var db = firebase.firestore();
        var profile = {};

        await db.collection("userprofile").get().then(function(querySnapshot) {
            querySnapshot.forEach(function(doc) {
                profile = {
                    id:doc.id,
                    company:doc.data().company,
                    name: doc.data().name,
                    address:doc.data().address,
                    city:doc.data().city,
                    zip:doc.data().zip,
                    country:doc.data().country,
                    mail:doc.data().mail,
                    phone:doc.data().phone,
                    bankInfo: {
                        accOwner:doc.data().bankInfo.accOwner,
                        bank: doc.data().bankInfo.bank,
                        iban:doc.data().bankInfo.iban,
                        bic:doc.data().bankInfo.bic,
                    },
                    profilePic: doc.data().profilePic
                }
            });
        });
        return profile;
    }
}
export default DBProfile

