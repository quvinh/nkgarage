import React,{ useState } from "react";
import axios from "axios";
import { useHistory } from "react-router-dom";
import isEmpty from "validator/lib/isEmpty";

function AddItems(props) {
    const [id, setId] = useState('');
    const [batch_code, setBatch_code] = useState('');
    const [name, setName] = useState('');
    const [amount, setAmount] = useState('');
    const [unit, setUnit] = useState('');
    const [price, setPrice] = useState('');
    const [status, setStatus] = useState('');
    const [note, setNote] = useState('')

    const history = useHistory();

    const handleId = (e) => {
        setId(e.target.value);
    }

    const handleBatch_code = (e) => {
        setBatch_code(e.target.value);
    }

    const handleName = (e) => {
        setName(e.target.value);
    }

    const handleAmount = (e) => {
        setAmount(e.target.value);
    }

    const handleUnit = (e) => {
        setUnit(e.target.value);
    }

    const handlePrice = (e) => {
        setPrice(e.target.value);
    }

    const handleStatus = (e) => {
        setStatus(e.target.value);
    }

    const handleNote = (e) => {
        setNote(e.target.value);
    }

    const handleAddItems = () => {
        const data = {
            id: id,
            batch_code: batch_code,
            name: name,
            amount: amount,
            unit: unit,
            price: price,
            status: status,
            note: note
        }
        console.log(data);
        axios.post('http://127.0.0.1:8000/api/admin/items/store', data)
        .then(res=> {
            console.log('Added successfully', res)
            history.push('/items')
        }).catch(err => {
            const isValid = validatorAll()
            console.log(isValid)
        })
    }
    const validatorAll = () => {
        const msg = {}
        if(isEmpty(id)) {
            msg.id = 'Please enter your item_id'
        }
        else if(isEmpty(batch_code)) {
            msg.batch_code = 'Please enter your unit'
        }
        else if(isEmpty(name)) {
            msg.name = 'Please enter your unit'
        }
        else if(isEmpty(amount)) {
            msg.amount = 'Please enter your status'
        }
        else if(isEmpty(unit)) {
            msg.unit = 'Please enter your amount'
        }
        else if(isEmpty(price)) {
            msg.price = 'Please enter your created_by'
        }
        else if(isEmpty(status)) {
            msg.status = 'Please enter your created_by'
        }
        setValidationMsg(msg)
        if(Object.keys(msg).length > 0) return false
        return true
    }
    return (
        <div>
            <h2>Add Item</h2>
            <br/>
            <form>
                <div className='mb-3'>
                    <label>ID</label>
                    <input
                        type='text'
                        className='form-control'
                        id='id'
                        placeholder='Enter ID'
                        // value={data.name}
                        value={id}
                        onChange={handleId}
                        required />
                </div>
                <div className='mb-3'>
                    <label>Batch code</label>
                    <input
                        type='text'
                        className='form-control'
                        id='batch_code'
                        placeholder='Enter Batch code'
                        // value={data.name}
                        value={batch_code}
                        onChange={handleBatch_code}
                        required />
                </div>
                <div className='mb-3'>
                    <label>name</label>
                    <input
                        type='text'
                        className='form-control'
                        id='name'
                        placeholder='Enter Name'
                        value={name}
                        onChange={handleName}
                        required />
                </div>
                <div className='mb-3'>
                    <label>Amount</label>
                    <input
                        type='number'
                        className='form-control'
                        id='amount'
                        placeholder='Enter Amount'
                        value={amount}
                        onChange={handleAmount}
                        required />
                </div>
                <div className='mb-3'>
                    <label>Unit</label>
                    <input
                        type='text'
                        className='form-control'
                        id='unit'
                        placeholder='Enter Unit'
                        value={unit}
                        onChange={handleUnit}/>
                </div>
                <div className='mb-3'>
                    <label>Price</label>
                    <input
                        type='text'
                        className='form-control'
                        id='price'
                        placeholder='Enter Unit'
                        value={price}
                        onChange={handlePrice}/>
                </div>
                <div className='mb-3'>
                    <label>Status</label>
                    <input
                        type='text'
                        className='form-control'
                        id='status'
                        placeholder='Enter Status'
                        value={price}
                        onChange={handleStatus}/>
                </div>
                <div className='mb-3'>
                    <label>Note</label>
                    <input
                        type='text'
                        className='form-control'
                        id='note'
                        placeholder='Enter Note'
                        value={note == null ? '' : note}
                        onChange={handleNote}/>
                </div>
                <button type='button' onClick={handleAddItems} className='btn btn-primary' >Save</button>
            </form>
        </div>
    );
}

export default AddItems;