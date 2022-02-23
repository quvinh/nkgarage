import React, {useEffect, useState} from 'react';
import axios from 'axios';
import { useHistory } from 'react-router-dom';

function EditItem(props) {
    const [id, setId] = useState('');
    const [batch_code, setBatch_code] = useState('');
    const [name, setName] = useState('');
    const [amount, setAmout] = useState('');
    const [unit, setUnit] = useState('');
    const [price, setPrice] = useState('');
    const [status, setStatus] = useState('');
    const [note, setNote] = useState('');
    const [msg, setMsg] = useState('');

    const history = useHistory();

    const handleIdChange = (e) => {
        setId(e.target.value);
    }

    const handleBatch_codeChange = (e) => {
        setBatch_code(e.target.value);
    }

    const handleNameChange = (e) => {
        setName(e.target.value);
    }

    const handleAmountChange = (e) => {
        setAmount(e.target.value);
    }

    const handleUnitChange = (e) => {
        setUnit(e.target.value);
    }

    const handlePriceChange = (e) => {
        setPrice(e.target.value);
    }

    const handleStatusChange = (e) => {
        setStatus(e.target.value);
    }

    const handleNoteChange = (e) => {
        setCreated_by(e.target.value);
    }
    const handleUpdateImport = () => {
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
        axios.put('http://127.0.0.1:8000/api/admin/items/update/' 
            + props.match.params.id, data)
        .then(response => {
            setMsg('Update Successfully')
            console.log('Edited Successfully')
            history.push('/items')
        }).catch((error) => {
            console.log(error)
            setMsg('Something went wrong')
        }) 
    }
    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/items/show/' 
            + props.match.params.id)
        .then(response => {
            setId(response.data.data.item_id)
            setBatch_code(response.data.data.amount)
            setName(response.data.data.unit)
            setAmount(response.data.data.unit)
            setUnit(response.data.data.unit)
            setPrice(response.data.data.unit)
            setStatus(response.data.data.status)
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
                <button type='button' onClick={handleUpdateImport} className='btn btn-primary' >Save</button>
            </form>
        </div>
    );
}

export default EditImport;