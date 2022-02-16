import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { useHistory } from 'react-router-dom';

function Edit(props) {
    const [name, setName] = useState('');
    const [position, setPosition] = useState('');
    const [msg, setMsg] = useState('');
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
        axios.get('http://127.0.0.1:8000/api/shelves/update' + props.match.params.id, data)
        .then(response => {
            setMsg('Updated Successfully')
            console.log('Updated Successfully', response)
            history.push('/')
        }).catch(error => {
            setMsg('Whups! Wrong')
            console.log('Wrong some where',error)
        })
    }

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/sheleves/update' + props.match.params.id, data)
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
                        required
                    />
                </div>
                <div className='mb-3'>
                    <label>Position</label>
                    <input 
                        type='string'
                        classPosition='form-control'
                        id='position'
                        placeholder='Position Shelves'
                        value={position}
                        required
                    />
                </div>
            </form>            
        </div>
    );
}

export default Edit;