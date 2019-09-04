class Customer {
    constructor(id, name, mail, phone1, address, city, zip, country, comments) {
        this.id = id;
        this.name = name,
        this.mail = mail,
        this.phone1 = phone1,
        this.address = address,
        this.city = city,
        this.zip = zip,
        this.country = country,
        this.comments = comments
    }

    setId(newId) { return this.id = newId }
    getId() { return this.id; }

    getName() { return this.name; }
    setName(newName) { return this.name = newName; }

    getMail() { return this.mail; }
    setMail(newMail) { return this.mail = newMail; }

    getPhone1() { return this.phone1; }
    setPhone1(newPhone1) { return this.phone1 = newPhone1; }

    getAddress() { return this.address; }
    setAddress(newAddress) { return this.address = newAddress; }

    getCity() { return this.city; }
    setCity(newCity) { return this.city = newCity; }

    getZip() { return this.zip; }
    setZip(newZip) { return this.zip = newZip; }

    getCountry() { return this.country; }
    setCountry(newCountry) { return this.country = newCountry; }

    getComments() { return this.comments; }
    setComments(newComments) { return this.comments = newComments; }
}
export default Customer