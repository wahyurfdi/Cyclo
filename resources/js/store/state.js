export default {
    token: '',
    profile: '',
    toast: {
        isShow: false,
        message: ''
    },
    trashTypes: [
        {
            id: 1,
            title: 'Plastik',
            description: 'Sampah berbahan plastik',
            image: '/img/trash-type/trash-01.jpg',
            qty: 0,
            coinPerQty: 10,
            weightPerQty: 0.5
        },
        {
            id: 2,
            title: 'Kertas',
            description: 'Sampah berbahan kertas',
            image: '/img/trash-type/trash-02.jpg',
            qty: 0,
            coinPerQty: 5,
            weightPerQty: 0.1
        },
        {
            id: 3,
            title: 'Kaleng',
            description: 'Sampah berbahan kaleng',
            image: '/img/trash-type/trash-03.jpg',
            qty: 0,
            coinPerQty: 25,
            weightPerQty: 0.5
        },
        {
            id: 4,
            title: 'Kaca',
            description: 'Sampah berbahan kaca',
            image: '/img/trash-type/trash-04.jpg',
            qty: 0,
            coinPerQty: 50,
            weightPerQty: 0.8
        }
    ]
}