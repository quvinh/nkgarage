import axios from 'axios';
import React, { useEffect } from 'react';

function EditDetailItem(props) {
    const [item_id, setItem_id] = useState('');
    const [category_id, setCategory_id] = useState('');
    const [warehouse_id, setWarehouse_id] = useState('');
    const [shelf_id, setShelf_id] = useState('');
    const [validationMsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleCategory_idChange = (e) => {
        setCategory_id(e.target.value)
    }
    const handleWarehouse_idChange = (e) => {
        setWarehouse_id(e.target.value)
    }
    const handleShelf_idChange = (e) => {
        setShelf_id(e.target.value)
    }
    const handleItem_idChange = (e) => {
        setItem_id(e.target.value)
    }

    const handleUpdate = () => {
        const data = {
            item_id: item_id,
            category_id: category_id,
            shelf_id: shelf_id,
            warehouse_id: warehouse_id
        }
        console.log(data)
        axios.post('http://127.0.0.1:8000/api/admin/detail_item/update/' + props.match.params.id, data)
        .then(res => {
            console.log('Add Successfully', res)
            history.push('/detail_item')
        }).catch(err => {
            const isValid = validatorAll()
            console.log(isValid)
        })
    }

    const validatorAll = () => {
        const msg = {}
        if(isEmpty(item_id)) {
            msg.item_id = 'Input item_id'
        }
        if(isEmpty(category_id)) {
            msg.category_id = 'Input item_id'
        }
        if(isEmpty(warehouse_id)) {
            msg.warehouse_id = 'Input item_id'
        }
        if(isEmpty(shelf_id)) {
            msg.shelf_id = 'Input item_id'
        }
        setValidationMsg(msg)
        if(Object.keys(msg).length > 0) return false
        return true
    }

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/detail_item/show/' + props.match.params.id)
        .then(res => {
            setItem_id(res.data.data.item_id)
            setCategory_id(res.data.data.category_id)
            setWarehouse_id(res.data.data.warehouse_id)
            setShelf_id(res.data.data.shelf_id)
        })
    }, [])

    return (
        <div>
            <h1>Edit</h1>
            <form>
                <div className='mb-3'>
                    <label>Item ID</label>
                    <input
                        type='string'
                        className='form-control'
                        id='item_id'
                        name='item_id'
                        placeholder=''
                        value={item_id}
                        onChange={handleItem_idChange}
                    />
                </div>
                <p className='text-danger'>{validationMsg.item_id}</p>

                <div className='mb-3'>
                    <label>Category ID</label>
                    <input
                        type='string'
                        className='form-control'
                        id='category_id'
                        name='category_id'
                        placeholder=''
                        value={category_id}
                        onChange={handleCategory_idChange}
                    />
                </div>
                <p className='text-danger'>{validationMsg.category_id}</p>

                <div className='mb-3'>
                    <label>Warehouse ID</label>
                    <input
                        type='string'
                        className='form-control'
                        id='warehouse_id'
                        name='warehouse_id'
                        placeholder=''
                        value={warehouse_id}
                        onChange={handleWarehouse_idChange}
                    />
                </div>
                <p className='text-danger'>{validationMsg.warehouse_id}</p>

                <div className='mb-3'>
                    <label>Shelf ID</label>
                    <input
                        type='string'
                        className='form-control'
                        id='shelf_id'
                        name='shelf_id'
                        placeholder=''
                        value={shelf_id}
                        onChange={handleShelf_idChange}
                    />
                </div>
                <p className='text-danger'>{validationMsg.shelf_id}</p>
                <button type='button' onClick={handleUpdate} className='btn btn-primary'>Save</button>
            </form>
        </div>
    );
}

export default EditDetailItem;
