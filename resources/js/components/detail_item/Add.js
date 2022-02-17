import axios from 'axios';
import React, { useState } from 'react';
import { useHistory } from 'react-router-dom';
import isEmpty from 'validator/lib/isEmpty';

function AddDetailItem(props) {
    const [item_id, setItem_id] = useState('');
    const [category_id, setCategory_id] = useState('');
    const [warehouse_id, setWarehouse_id] = useState('');
    const [shelf_id, setShelf_id] = useState('');
    const [validationMsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleCategory_id = (e) => {
        setCategory_id(e.target.value)
    }
    const handleWarehouse_id = (e) => {
        setWarehouse_id(e.target.value)
    }
    const handleShelf_id = (e) => {
        setShelf_id(e.target.value)
    }
    const handleItem_id = (e) => {
        setItem_id(e.target.value)
    }

    const handleAdd = () => {
        const data = {
            item_id: item_id,
            category_id: category_id,
            shelf_id: shelf_id,
            warehouse_id: warehouse_id
        }
        console.log(data)
        axios.post('http://127.0.0.1:8000/api/admin/detail_item/store', data)
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

    return (
        <div>
            <h1>Add</h1>
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
                        onChange={handleItem_id}
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
                        onChange={handleCategory_id}
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
                        onChange={handleWarehouse_id}
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
                        onChange={handleShelf_id}
                    />
                </div>
                <p className='text-danger'>{validationMsg.shelf_id}</p>
                <button type='button' onClick={handleAdd} className='btn btn-primary'>Save</button>
            </form>
        </div>
    );
}

export default AddDetailItem;
