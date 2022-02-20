import axios from 'axios';
import isEmpty from 'validator/lib/isEmpty';
import React, { useState } from 'react';
import { useHistory } from 'react-router-dom';

function AddExport(props) {
    const [detail_item_id, setDetail_item_id] = useState('');
    const [amount, setAmount] = useState('');
    const [unit, setUnit] = useState('');
    const [status, setStatus] = useState('');
    const [note, setNote] = useState('');
    const [created_by, setCreated_by] = useState('');
    const [validationMsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleDetail_item_id = (e) => {
        setDetail_item_id(e.target.value)
    }
    const handleAmount = (e) => {
        setAmount(e.target.value)
    }
    const handleUnit = (e) => {
        setUnit(e.target.value)
    }
    const handleStatus = (e) => {
        setStatus(e.target.value)
    }
    const handleNote = (e) => {
        setNote(e.target.value)
    }
    const handleCreated_by = (e) => {
        setCreated_by(e.target.value)
    }
    const handleAdd = () => {
        const data = {
            detail_item_id: detail_item_id,
            amount: amount,
            unit: unit,
            status: status,
            note: note,
            created_by: created_by
        }
        console.log(data)
        axios.post('http://127.0.0.1:8000/api/admin/export/store', data)
        .then(res => {
            console.log('Add Successfully')
            history.push('/export')
        }).catch(err => {
            const isValid = validatorAll()
            console.log(isValid)
        })
    }

    const validatorAll = () => {
        const msg = {}
        if(isEmpty(detail_item_id)) {
            msg.detail_item_id = 'Input detail_item_id'
        }
        if(isEmpty(amount)) {
            msg.amount = 'Input detail_item_id'
        }
        if(isEmpty(unit)) {
            msg.unit = 'Input detail_item_id'
        }
        if(isEmpty(status)) {
            msg.status = 'Input detail_item_id'
        }
        if(isEmpty(note)) {
            msg.note = 'Input detail_item_id'
        }
        if(isEmpty(created_by)) {
            msg.created_by = 'Input detail_item_id'
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
                    <label>Detail Item Id</label>
                    <input
                        type='string'
                        className='form-control'
                        id='detail_item_id'
                        name='detail_item_id'
                        placeholder=''
                        value={detail_item_id}
                        onChange={handleDetail_item_id}
                    />
                </div>
                <p className='text-danger'>{validationMsg.detail_item_id}</p>
                <div className='mb-3'>
                    <label>Amount</label>
                    <input
                        type='string'
                        className='form-control'
                        id='amount'
                        name='amount'
                        placeholder=''
                        value={amount}
                        onChange={handleAmount}
                    />
                </div>
                <p className='text-danger'>{validationMsg.amount}</p>

                <div className='mb-3'>
                    <label>Unit</label>
                    <input
                        type='string'
                        className='form-control'
                        id='unit'
                        name='unit'
                        placeholder=''
                        value={unit}
                        onChange={handleUnit}
                    />
                </div>
                <p className='text-danger'>{validationMsg.unit}</p>

                <div className='mb-3'>
                    <label>Status</label>
                    <input
                        type='string'
                        className='form-control'
                        id='status'
                        name='status'
                        placeholder=''
                        value={status}
                        onChange={handleStatus}
                    />
                </div>
                <p className='text-danger'>{validationMsg.status}</p>

                <div className='mb-3'>
                    <label>Note</label>
                    <input
                        type='text'
                        className='form-control'
                        id='note'
                        name='note'
                        placeholder=''
                        value={note}
                        onChange={handleNote}
                    />
                </div>

                <div className='mb-3'>
                    <label>Created By</label>
                    <input
                        type='string'
                        className='form-control'
                        id='created_by'
                        name='created_by'
                        placeholder=''
                        value={created_by}
                        onChange={handleCreated_by}
                    />
                </div>
                <p className='text-danger'>{validationMsg.created_by}</p>
                <button type='button' className='btn btn-primary' onClick={handleAdd}>Save</button>
            </form>
        </div>
    );
}

export default AddExport;
