import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';

function EditExport(props) {
    const [detail_item_id, setDetail_item_id] = useState('');
    const [amount, setAmount] = useState('');
    const [unit, setUnit] = useState('');
    const [status, setStatus] = useState('');
    const [note, setNote] = useState('');
    const [created_by, setCreated_by] = useState('');
    const [validationMsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleDetail_item_idChange = (e) => {
        setDetail_item_id(e.target.value)
    }
    const handleAmountChange = (e) => {
        setAmount(e.target.value)
    }
    const handleUnitChange = (e) => {
        setUnit(e.target.value)
    }
    const handleStatusChange = (e) => {
        setStatus(e.target.value)
    }
    const handleNoteChange = (e) => {
        setNote(e.target.value)
    }
    const handleCreated_byChange = (e) => {
        setCreated_by(e.target.value)
    }
    const handleUpdate = () => {
        const data = {
            detail_item_id: detail_item_id,
            amount: amount,
            unit: unit,
            status: status,
            note: note,
            created_by: created_by
        }
        console.log(data)
        axios.put('http://127.0.0.1:8000/api/admin/export/update/' + props.match.params.id, data)
        .then(res => {
            console.log('Update Successfully', res)
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
            msg.amount = 'Input amount'
        }
        if(isEmpty(unit)) {
            msg.unit = 'Input unit'
        }
        if(isEmpty(status)) {
            msg.status = 'Input status'
        }
        if(isEmpty(created_by)) {
            msg.created_by = 'Input created_by'
        }
        setValidationMsg(msg)
        if(Object.keys(msg).length > 0) return false
        return true
    }

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/export/show/' + props.match.params.id)
        .then(res => {
            setDetail_item_id(res.data.data.detail_item_id)
            setAmount(res.data.data.amount)
            setStatus(res.data.data.status)
            setUnit(res.data.data.unit)
            setNote(res.data.data.note)
            setCreated_by(res.data.data.created_by)
        })
    }, [])

    return (
        <div>
            <h1>Edit</h1>
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
                        onChange={handleDetail_item_idChange}
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
                        onChange={handleAmountChange}
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
                        onChange={handleUnitChange}
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
                        onChange={handleStatusChange}
                    />
                </div>
                <p className='text-danger'>{validationMsg.status}</p>

                <div className='mb-3'>
                    <label>Note</label>
                    <input
                        type='string'
                        className='form-control'
                        id='note'
                        name='note'
                        placeholder=''
                        value={note}
                        onChange={handleNoteChange}
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
                        onChange={handleCreated_byChange}
                    />
                </div>
                <p className='text-danger'>{validationMsg.created_by}</p>
                <button type='button' className='btn btn-primary' onClick={handleUpdate}>Save</button>
            </form>
        </div>
    );
}

export default EditExport;
