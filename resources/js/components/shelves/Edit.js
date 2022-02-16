import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';
import isEmpty from 'validator/lib/isEmpty'

function Edit(props) {
    const [name, setName] = useState('');
    const [position, setPosition] = useState('');
    const [validationmsg, setValidationMsg] = useState('');
    const history = useHistory();

    const handleNameChange = (e) => {
        setName(e.target.value)
    }
    const handlePositionChange = (e) => {
        setPosition(e.target.value)
    }
    const handleUpdate = () => {
        const data = {
            name: name,
            position: position
        }
        console.log(data)
        axios.get('http://127.0.0.1:8000/api/admin/shelf/update' + props.match.params.id, data)
        .then(response => {
            console.log('Updated Successfully', response)
            history.push('/')
        }).catch(error => {
            const isValid = validatorAll()
            console.log('Wrong some where',error)
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

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/adim/shelf/update' + props.match.params.id, data)
        .then(response => {
            setName(response.data.name),
            setPosition(response.data.position)
        })
    })

    return (
        <div>
            <h1>Update</h1>
            <h3>{msg}</h3>
            <form>
                <div className='mb-3'>
                    <label>Name</label>
                    <input
                        type='string'
                        className='form-control'
                        id='name'
                        placeholder='Name Shelves'
                        value={name}
                        onChange={handleNameChange}
                    />
                </div>
                <p className='text-danger'>{validationmsg.name}</p>
                <div className='mb-3'>
                    <label>Position</label>
                    <input
                        type='string'
                        classPosition='form-control'
                        id='position'
                        placeholder='Position Shelves'
                        value={position}
                        onChange={handlePositionChange}
                    />
                </div>
                <p className='text-danger'>{validationmsg.position}</p>
                <button type='button' onClick={handleUpdate} className='btn btn-primary'>Save</button>
            </form>
        </div>
    );
}

export default Edit;
