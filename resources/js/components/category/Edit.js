import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';
import isEmpty from 'validator/lib/isempty';

function Edit(props) {
    const [name, setName] = useState('');
    const [note, setNote] = useState('');
    const [validationmsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleNameChange = (e) => {
        setName(e.target.value)
    }
    const handleNoteChange = (e) => {
        setNote(e.target.value)
    }
    const handleUpdate = () => {
        const data = {
            name: name,
            note: note
        }
        console.log(data)
        axios.get('http://127.0.0.1:8000/api/admin/category/update'+ props.match.params.id, data)
        .then(res => {
            console.log('Update Successfully', res)
            history.push('/')
        }).catch(err => {
            const isValid = validatorAll()
            console.log(isValid)
        })
    }

    const validatorAll = () => {
        const msg = {}
        if(isEmpty(name)) {
            msg.name = 'Input name category'
        }
        setValidationMsg(msg)
        if(Object.keys(msg).length > 0) return false
        return true
    }

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/category/update' +props.match.params.id, data)
        .then(res => {
            setName(res.data.name)
            setNote(res.data.note)
        })
    })
    return (
        <div>
            <h1>Update</h1>
            <form>
                <div className='mb-3'>
                    <label>Name</label>
                    <input
                        type='string'
                        className='form-control'
                        id='name'
                        placeholder='Name category'
                        value={name}
                        onChange={handleNameChange}
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
                        onChange={handleNoteChange}
                    />
                </div>
                <button type='button' className='btn btn-primary' onClick={handleUpdate}>Save</button>
            </form>
        </div>
    );
}

export default Edit;
