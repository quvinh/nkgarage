import React, {useEffect, useState} from 'react';
import axios from 'axios';
import { useHistory } from 'react-router-dom';


function EditPermission(props) {
    const [name, setName] = useState('');
    const [note, setNote] = useState('');
    const [msg, setMsg] = useState('');
    const history = useHistory();

    const handleNameChange = (e) => {
        setName(e.target.value);
    }

    const handleNoteChange =(e) => {
        setNote(e.target.value);
    }

    const handleUpdate = () => {
        const data = {
            name: name,
            note: note
        }
        axios.put('http://127.0.0.1:8000/api/admin/auth_model/permission/update/' 
            + props.match.params.id, data)
        .then(response => {
            setMsg('Update Successfully')
            console.log('Edited Successfully')
            history.push('/permission')
        }).catch((error) => {
            console.log(error)
            setMsg('Something went wrong')
        }) 
    }
    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/auth_model/permission/show/' 
            + props.match.params.id)
        .then(response => {
            setName(response.data.data.name)
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
                    <label>Name</label>
                    <input
                        type='text'
                        className='form-control'
                        id='name'
                        placeholder='Name'
                        // value={data.name}
                        value={name}
                        onChange={handleNameChange}
                        required />
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
                <button type='button' onClick={handleUpdate} className='btn btn-primary' >Save</button>
            </form>
        </div>
    );
}

export default EditPermission;