const validate = (product, quantity, price) => {
    if (product === '' || quantity === '' || price === '') {
        alert('Please fill all fields')
        return false
    }
    return true
}

const formatPrice = (price) => {
    return price.toLocaleString('en-US', {
        style: 'currency',
        currency: 'USD'
    })
}

const formatDate = (date) => {
    return date.toLocaleString('en-US', {
        dateStyle: 'medium',
        timeStyle: 'medium'
    })
}

const fillProducts = (products) => {
    const table = document.getElementById('products')
    const tbody = table.querySelector('tbody')
    tbody.innerHTML = ''

    products.forEach((product) => {
        const row = document.createElement('tr')
        row.innerHTML = `
            <td>${product.product}</td>
            <td>${product.quantity}</td>
            <td>${formatPrice(product.price)}</td>
            <td>${formatDate(new Date(product.submitted))}</td>
            <td>${formatPrice(product.total)}</td>
            <td class="d-flex flex-nowrap gap-2">
                <div>
                    <button class="btn btn-primary btn-sm" onclick="fillForm('${product.id}', '${product.product}', ${product.quantity}, ${product.price})">Edit</button>
                </div>
                <div>
                    <button class="btn btn-danger btn-sm" onclick="deleteProduct('${product.id}')">Delete</button>
                </div>
            </td>
        `
        tbody.appendChild(row)
    })
}

const fillForm = (id, product, quantity, price) => {
    const form = document.getElementById('form')
    form.reset()
    form.querySelector('#id').value = id
    form.querySelector('#product').value = product
    form.querySelector('#quantity').value = quantity
    form.querySelector('#price').value = price
}

const createProduct = async (product, quantity, price) => {
    try {
        await fetch('api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                product,
                quantity,
                price
            })
        })
        alert('Product created successfully')
        location.reload()
    } catch (error) {
        console.error(error)
    }
}

const updateProduct = async (id, product, quantity, price) => {
    try {
        await fetch(`api.php`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id,
                product,
                quantity,
                price
            })
        })
        alert('Product updated successfully')
        location.reload()
    } catch (error) {
        console.error(error)
    }
}

window.addEventListener('load', async (event) => {
    try {
        const response = await fetch('api.php')
        const products = await response.json()
        fillProducts(products)
    } catch (error) {
        console.error(error)
    }
})

window.deleteProduct = async (id) => {
    try {
        ok = confirm('Are you sure you want to delete this product?')
        if (!ok) {
            return
        }
        await fetch(`api.php`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id
            })
        })
        alert('Product deleted successfully')
        location.reload()
    } catch (error) {
        console.error(error)
    }
}

window.addEventListener('DOMContentLoaded', (event) => {
    const form = document.getElementById('form')
    form.addEventListener('submit', async (event) => {
        event.preventDefault()

        const formData = new FormData(form)
        const id = formData.get('id')
        const product = formData.get('product')
        const quantity = formData.get('quantity')
        const price = formData.get('price')

        if (!validate(product, quantity, price)) {
            return
        }

        if (id == '') {
            await createProduct(product, quantity, price)
        } else {
            console.log(id, product)
            await updateProduct(id, product, quantity, price)
        }
    })
})
