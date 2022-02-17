import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';
import isEmpty from 'validator/lib/isEmpty'

function EditShelf(props) {
    const [name, setName] = useState('');
    const [position, setPosition] = useState('');
    const [note, setNote] = useState('');
    const [validationMsg, setValidationMsg] = useState('');
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
            position: position,
        }
        console.log(data)
        axios.put('http://127.0.0.1:8000/api/admin/shelf/update/'+ props.match.params.id, data)
        .then(res => {
            console.log('Update Successfully', res)
            history.push('/shelf')
        }).catch(err => {
            const isValid = validatorAll()
            console.log(isValid)
        })
    }

    const validatorAll = () => {
        const msg = {}
        if(isEmpty(name)) {
            msg.name = 'Input name shelf'
        }
        if(isEmpty(position)) {
            msg.position = 'Input position shelf'
        }
        setValidationMsg(msg)
        if(Object.keys(msg).length > 0) return false
        return true
    }

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/shelf/show/' + props.match.params.id)
        .then(response => {
            setName(response.data.data.name),
            setPosition(response.data.data.position)
        })
    }, []);

    return (
        <div>
            <h1>Edit</h1>
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
                        onChange={handleNameChange}
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
                        onChange={handlePositionChange}
                    />
                </div>
                <p className='text-danger'>{validationMsg.position}</p>
                <button type='button' onClick={handleUpdate} className='btn btn-primary'>Save</button>
            </form>
        </div>
    );
}

export default EditShelf;
