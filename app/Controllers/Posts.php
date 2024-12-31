<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Posts extends ResourceController
{
    protected $modelName = 'App\Models\PostModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Post not found');
    }

    public function create()
    {
        // $data = $this->request->getPost();
        $data = $this->request->getJSON(true);
        
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors('Failed to create post');
    }

    public function update($id = null)
    {
        // $data = $this->request->getRawInput();
        $data = $this->request->getJSON(true);

        if ($this->model->update($id, $data)) {
            return $this->respond($data);
        }
        return $this->failValidationErrors('Failed to update post');
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }
        return $this->failNotFound('Post not found');
    }
}
