class Product {
    constructor(id, product_nr, name, description, price, priceGross, taxPercentage, inStock) {
        this.id = id;
        this.product_nr = product_nr,
        this.name = name,
        this.description = description,
        this.price = price,
        this.priceGross = priceGross,
        this.taxPercentage = taxPercentage,
        this.inStock = inStock
    }

    setId(newId) { return this.id = newId }
    getId() { return this.id; }

    getName() { return this.name; }
    setName(newName) { return this.name = newName; }

    getProduct_nr() { return this.product_nr; }
    setProduct_nr(product_nr) { return this.product_nr = product_nr; }

    getDescription() { return this.description; }
    setDescription(description) { return this.description = description; }

    getPrice() { return this.price; }
    setPrice(price) { return this.price = price; }

    getPriceGross() { return this.priceGross; }
    setPriceGross(priceGross) { return this.priceGross = priceGross; }

    getTaxPercentage() { return this.taxPercentage; }
    setTaxPercentage(taxPercentage) { return this.taxPercentage = taxPercentage; }

    getInStock() { return this.inStock; }
    setInStock(inStock) { return this.inStock = inStock; }
}
export default Product