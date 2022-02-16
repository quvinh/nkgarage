import axios from 'axios';
import React, { useState } from 'react';
import {useHistory} from 'react-router-dom'
import isEmpty from 'validator/lib/isEmpty';

function Add(props) {
    const [name, setName] = useState('');
    const [location, setLocation] = useState('');
    const [note, setNote] = useState('');
    const [validationmsg, setValidationMsg] = useState('');
    const history = useHistory()

    const handleName = (e) => {
        setName(e.target.value)
    }
    const handleLocation = (e) => {
        setLocation(e.target.value)
    }
    const handleNote = (e) => {
        setNote(e.target.value)
    }
    const handleAdd = () => {
        const data = {
            name: name,
            location: location,
            note: note
        }
        console.log(data);
        axios.post('http://127.0.0.1:8000/api/admin/warehouse/store', data)
        .then(resopnse => {
            console.log('Added Successfully', resopnse)
            history.push('/')
        }).catch(error => {
            const isValid = validatorAll()
            console.log('Wrong some where', error)
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

    return (
        <div>
            <h2>Add</h2>
            <br/>
            <form>
                <div className='mb-3'>
                    <label>Name</label>
                    <input
                        type='string'
                        className='form-control'
                        id='name'
                        placeholder='Name Warehouse'
                        value={name}
                        onChange={handleName}
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
                        onChange={handleLocation}
                    />
                </div>
                <p className='text-danger'>{validationmsg.location}</p>
                <div className='mb-3'>
                    <label>Note</label>
                    <input
                        type='string'
                        classNote='form-control'
                        id='note'
                        placeholder='Note Warehouse'
                        value={note}
                        onChange={handleNote}
                    />
                </div>
                <button type='button' onClick={handleAdd} className='btn btn-primary'>Save</button>
            </form>
        </div>
    );
}

export default Add;
