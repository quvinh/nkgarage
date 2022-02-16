import axios from 'axios';
import React, { useState } from 'react';
import { useHistory } from 'react-router-dom';
import isEmpty from 'validator/lib/isempty';

function Add(props) {
    const [name, setName] = useState('');
    const [note, setNote] = useState('');
    const [validationmsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleName = (e) => {
        setName(e.target.value)
    }
    const handleNote = (e) => {
        setNote(e.target.value)
    }

    const handleAdd = () => {
        const data = {
            name: name,
            note: note
        }
    }
    console.log(data)
    axios.post('http://127.0.0.1:8000/api/admin/category/store', data)
    .then(res => {
        console.log('Add Successfully', res)
        history.push('/')
    }).catch(err => {
        const isValid = validatorAll()
        console.log('Wrong', err)
    })

    const validatorAll = () => {
        const msg = {}
        if(isEmpty(name)) {
            msg.name = 'Input name category'
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
                    <label>Name</label>
                    <input
                        type='string'
                        className='form-control'
                        id='name'
                        placeholder='Name Category'
                        value={name}
                        onChange={handleName}
                    />
                </div>
                <p className='text-danger'>{validationmsg.name}</p>
                <div className='mb-3'>
                    <label>Note</label>
                    <input
                        type='text'
                        className='form-control'
                        id='note'
                        placeholder=''
                        value={note}
                        onChange={handleName}
                    />
                </div>
                <button type='button' onClick={handleAdd} className='btn btn-primary'>Save</button>
            </form>
        </div>
    );
}

export default Add;
