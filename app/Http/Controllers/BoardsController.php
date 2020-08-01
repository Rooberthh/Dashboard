<?php

    namespace App\Http\Controllers;

    use App\Models\Board;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Validation\Rule;

    class BoardsController extends Controller
    {

        public function index()
        {
            $boards = auth()->user()->accessibleBoards();

            return view('boards.index', ['boards', $boards]);
        }

        public function show($id)
        {
            $board = Board::with('statuses.tasks.objectives')->findOrFail($id);

            return response($board, 200);
        }

        /**
         * @param Request $request
         * @return Response|\Laravel\Lumen\Http\ResponseFactory
         * @throws \Illuminate\Validation\ValidationException
         */
        public function store(Request $request)
        {
            $this->validate($request, [
                'name' => ['required', Rule::unique('boards')],
                'user_id' => ['required'],
            ]);

            $board = Board::create([
                'name' => $request->get('name'),
                'user_id' => $request->get('user_id')
            ]);

            return response($board, 200);
        }

        public function update($id, Request $request)
        {
            $this->validate($request, [
                'name' => 'sometimes',
            ]);

            $board = Board::find($id);

            //Refactor
            if((int)$board->user_id !== (int)$request->get('user_id')){
                return response('You do not have access to update board', 403);
            }

            $board->update([
                'name' => $request->get('name'),
            ]);

            return response($board, 200);
        }

        /**
         * @param $id
         * @return Response|\Laravel\Lumen\Http\ResponseFactory
         */
        public function destroy($id)
        {
            $board = Board::find($id);

            $this->authorize('manage', $board);

            $board->delete();

            return response('Board have been deleted', 200);
        }
    }
