import axios from 'axios';
import React, { useState } from 'react';
import { useHistory } from 'react-router-dom';
import isEmpty from 'validator/lib/isEmpty';

function AddShelf(props) {
    const [name, setName] = useState('');
    const [position, setPosition] = useState('');
    const [note, setNote] = useState('');
    const [validationMsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleName = (e) => {
        setName(e.target.value)
    }
    const handlePosition = (e) => {
        setPosition(e.target.value)
    }

    const handleAdd = () => {
        const data = {
            name: name,
            position: position,
        }
        console.log(data)
        axios.post('http://127.0.0.1:8000/api/admin/shelf/store', data)
        .then(response => {
            console.log('Added Successfully', response);
            history.push('/shelf');
        }).catch(error => {
            const isValid = validatorAll()
            console.log(isValid)
        })
    }

    const validatorAll = () => {
        const msg = {}
        if(isEmpty(name)) {
            msg.name = 'Input name shelves'
        }
        if(isEmpty(position)) {
            msg.position = 'Input position shelves'
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
                        name='name'
                        placeholder='Name Shelves'
                        value={name}
                        onChange={handleName}
                    />
                </div>
                <p className='text-danger'>{validationMsg.name}</p>
                <div className='mb-3'>
                    <label>Position</label>
                    <input
                        type='string'
                        className='form-control'
                        id='position'
                        name='position'
                        placeholder='Position Shelves'
                        value={position}
                        onChange={handlePosition}
                    />
                </div>
                <p className='text-danger'>{validationMsg.position}</p>
                <button type='button' onClick={handleAdd} className='btn btn-primary'>Save</button>
            </form>
        </div>
    );
}

export default AddShelf;
