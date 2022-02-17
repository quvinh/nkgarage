import React, { useState } from 'react';
import axios from 'axios';
import { useHistory } from 'react-router-dom';
import isEmpty from 'validator/lib/isEmpty';

function AddRoles(props) {
    const [name, setName] = useState('');
    const [note, setNote] = useState('');
    const [validationMsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleName = (e) => {
        setName(e.target.value);
    }

    const handleNote = (e) => {
        setNote(e.target.value);
    }

    const handleAddRoles = () => {
        const data ={
            name: name,
            note: note
        }
        console.log(data);
        axios.post('http://127.0.0.1:8000/api/admin/auth_model/roles/store', data)
        .then(res => {
            console.log('Added successfully', res)
            history.push('/roles')
        }).catch(error => {
            const isValid = validatorAll()
            console.log(isValid)
        })
    }

    const validatorAll = () => {
        const msg = {}
        if(isEmpty(name)) {
            msg.name = 'Please enter your name'
        }

        setValidationMsg(msg)
        if(Object.keys(msg).length > 0) return false
        return true
    }

    return (
        <div>
            <h2>Roles Add</h2>
            <br/>
            <form>
                <div className='mb-3'>
                    <label>Name</label>
                    <input
                        type='text'
                        className="form-control"
                        id='name'
                        placeholder='Enter Name'
                        value={name}
                        onChange={handleName}/>
                </div>
                <p className='text-danger'>{validationMsg.name}</p>
                <div className='mb-3'>
                    <label>Note</label>
                    <input
                        type='text'
                        className='form-control'
                        id='note'
                        placeholder='Enter note'
                        value={note}
                        onChange={handleNote}/>
                </div>
                <button type='button' onClick={handleAddRoles} className='btn btn-primary'>Save</button>
            </form>
        </div>
    );
}

export default AddRoles;