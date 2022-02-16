import React, { useCallback, useEffect, useState } from 'react';
import {useHistory} from 'react-router-dom'
import axios from 'axios';
import isEmpty from 'validator/lib/isEmpty';

function Edit(props) {
    const [name, setName] = useState('');
    const [location, setLocation] = useState('');
    const [note, setNote] = useState('');
    const [validationmsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleNameChange = (e) => {
        setName(e.target.value);
    }
    const handleLocationChange = (e) => {
        setLocation(e.target.value);
    }
    const handleNoteChange = (e) => {
        setNote(e.target.value);
    }
    const handleUpdate = () => {
        const data = {
            name: name,
            location: location,
            note: note
        }
        axios.put('http://127.0.0.1:8000/api/admin/warehouse/update' + props.match.params.id, data)
        .then(response => {
            console.log('Edited successfully', response)
            history.push('/')
        }).catch((error) => {
            const valid = validatorAll()
            console.log(error)

        })
    }

    const validatorAll = () => {
        const msg = {}
        if(isEmpty(name)) {
            msg.name = 'Input name warehouse'
        }
        if(isEmpty(location)) {
            msg.location = 'Input location warehouse'
        }
        setValidationMsg(msg)
        if(Object.keys(msg).length > 0) return false
        return true
    }

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/warehouse' + props.match.params.id, data)
        .then(response => {
            setName(response.data.name)
            setLocation(response.data.location)
            setNote(response.data.note)
        })
    })

    return (
        <div>
            <h1>Edit</h1>
            <h3>{msg}</h3>
            <hr></hr>
            <form>
                <div className='mb-3'>
                    <label>Name</label>
                    <input
                        type='string'
                        className='form-control'
                        id='name'
                        placeholder='Name Warehouse'
                        value={name}
                        onChange={handleNameChange}
                    />
                </div>
                <p className='text-danger'>{validationmsg.name}</p>
                <div className='mb-3'>
                    <label>Location</label>
                    <input
                        type='string'
                        classLocation='form-control'
                        id='location'
                        placeholder='Location Warehouse'
                        value={location}
                        onChange={handleLocationChange}
                    />
                </div>
                <p className='text-danger'>{validationmsg.location}</p>
                <div className='mb-3'>
                    <label>Note</label>
                    <input
                        type='text'
                        classNote='form-control'
                        id='note'
                        placeholder='Note Warehouse'
                        value={note}
                        onChange={handleNoteChange}
                    />
                </div>
                <button type='button' onClick={handleUpdate} className='btn btn primary'>Save</button>
            </form>
        </div>
    );
}

export default Edit;
