import React,{ useState } from "react";
import axios from "axios";
import { useHistory } from "react-router-dom";
import isEmpty from "validator/lib/isEmpty";

function AddImport(props) {
    const [item_id, setItem_id] = useState('');
    const [amount, setAmount] = useState('');
    const [unit, setUnit] = useState('');
    const [status, setStatus] = useState('');
    const [created_by, setCreated_by] = useState('');
    const history = useHistory();

    const handleItem_id = (e) => {
        setItem_id(e.target.value);
    }

    const handleAmount = (e) => {
        setAmount(e.target.value);
    }

    const handleUnit = (e) => {
        setUnit(e.target.value);
    }

    const handleStatus = (e) => {
        setStatus(e.target.value);
    }

    const handleCreated_by = (e) => {
        setCreated_by(e.target.value);
    }

    const handleNote = (e) => {
        setNote(e.target.value);
    }

    const handleAddImport = () => {
        const data = {
            item_id: item_id,
            amount: amount,
            unit: unit,
            status: status,
            created_by: created_by
        }
        console.log(data);
        axios.post('http://127.0.0.1:8000/api/admin/import', data)
        .then(res=> {
            console.log('Added successfully', res)
            history.push('/import')
        }).catch(err => {
            const isValid = validatorAll()
            console.log(isValid)
        })
    }
    const validatorAll = () => {
        const msg = {}
        if(isEmpty(item_id)) {
            msg.item_id = 'Please enter your item_id'
        }
        else if(isEmpty(unit)) {
            msg.unit = 'Please enter your unit'
        }
        else if(isEmpty(status)) {
            msg.status = 'Please enter your status'
        }
        else if(isEmpty(amount)) {
            msg.amount = 'Please enter your amount'
        }
        else if(isEmpty(created_by)) {
            msg.created_by = 'Please enter your created_by'
        }
        setValidationMsg(msg)
        if(Object.keys(msg).length > 0) return false
        return true
    }
    return (
        <div>
            <h2>Permisson Add</h2>
            <br/>
            <form>
                <div className='mb-3'>
                    <label>Item_id</label>
                    <input
                        type='text'
                        className='form-control'
                        id='item_id'
                        placeholder='Enter item ID (1-20)'
                        // value={data.name}
                        value={item_id}
                        onChange={handleItem_id}
                        required />
                </div>
                <div className='mb-3'>
                    <label>Amount</label>
                    <input
                        type='number'
                        className='form-control'
                        id='amount'
                        placeholder='Enter Amount'
                        // value={data.name}
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
                        // value={data.name}
                        value={unit}
                        onChange={handleUnit}
                        required />
                </div>
                <div className='mb-3'>
                    <label>Status</label>
                    <input
                        type='binary'
                        className='form-control'
                        id='status'
                        placeholder='Enter Binary'
                        // value={data.name}
                        value={status}
                        onChange={handleStatus}
                        required />
                </div>
                <div className='mb-3'>
                    <label>Created_by</label>
                    <input
                        type='text'
                        className='form-control'
                        id='create_by'
                        placeholder='Enter Create_by'
                        value={created_by}
                        onChange={handleCreated_by}/>
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
                <button type='button' onClick={handleAddImport} className='btn btn-primary' >Save</button>
            </form>
        </div>
    );
}

export default AddImport;