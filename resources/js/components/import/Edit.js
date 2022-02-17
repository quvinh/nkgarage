import React, {useEffect, useState} from 'react';
import axios from 'axios';
import { useHistory } from 'react-router-dom';


function EditImport(props) {
    const [item_id, setItem_id] = useState('');
    const [amount, setAmount] = useState('');
    const [unit, setUnit] = useState('');
    const [status, setStatus] = useState('');
    const [created_by, setCreated_by] = useState('');
    const [msg, setMsg] = useState('');
    const history = useHistory();

    const handleItem_idChange = (e) => {
        setItem_id(e.target.value);
    }

    const handleAmountChange = (e) => {
        setAmount(e.target.value);
    }

    const handleUnitChange = (e) => {
        setUnit(e.target.value);
    }

    const handleStatusChange = (e) => {
        setStatus(e.target.value);
    }

    const handleCreated_byChange = (e) => {
        setCreated_by(e.target.value);
    }

    const handleNoteChange = (e) => {
        setCreated_by(e.target.value);
    }
    const handleUpdateImport = () => {
        const data = {
            item_id: item_id,
            amount: amount,
            unit: unit,
            status: status,
            created_by: created_by,
            note: note
        }
        axios.put('http://127.0.0.1:8000/api/admin/update/' 
            + props.match.params.id, data)
        .then(response => {
            setMsg('Update Successfully')
            console.log('Edited Successfully')
            history.push('/import')
        }).catch((error) => {
            console.log(error)
            setMsg('Something went wrong')
        }) 
    }
    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/auth_model/permission/show/' 
            + props.match.params.id)
        .then(response => {
            setItem_id(response.data.data.item_id)
            setAmount(response.data.data.amount)
            setUnit(response.data.data.unit)
            setStatus(response.data.data.status)
            setCreated_by(response.data.data.created_by)
            setNote(response.data.data.note)
        })
    }, []);

    return (
        <div>
            <h1>Edit</h1>
            <h3>{msg}</h3>
            <hr/>
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
                        onChange={handleItem_idChange}
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
                        onChange={handleAmountChange}
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
                        onChange={handleUnitChange}
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
                        onChange={handleStatusChange}
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
                        onChange={handleCreated_byChange}/>
                </div>
                <div className='mb-3'>
                    <label>Note</label>
                    <input
                        type='text'
                        className='form-control'
                        id='note'
                        placeholder='Enter Note'
                        value={note == null ? '' : note}
                        onChange={handleNoteChange}/>
                </div>
                <button type='button' onClick={handleUpdate} className='btn btn-primary' >Save</button>
            </form>
        </div>
    );
}

export default EditImport;