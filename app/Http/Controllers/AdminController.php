<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Category;

use App\Models\Order;

use App\Models\Product;

use App\Models\Role;

use App\Models\Permission;

use Barryvdh\DomPDF\Facade\Pdf;

use GuzzleHttp\Handler\Proxy;
use PhpParser\Node\Expr\FuncCall;

class AdminController extends Controller
{
    //
    public function view_category(){
    
        $data = Category::all();

        return view('admin.category', compact('data'));
    }

    public function add_category(Request $request){
        try{
        $category = new Category;

        $category->cat_name = $request-> category;
        $category->cat_description = $request->category_description;
        $category->save();

        toastr()->closeButton()->success('Category Added Successfully');
        } catch(\Exception $e){
         toastr()->closeButton()->error('Category Not Added');
        }
        return redirect()->back();
    }

    public function delete_category($id)
    {
        $data= Category::find($id);

        $data->delete();

        toastr()->closeButton()->success('Category Delete Successfully');
        
        return redirect()->back();
    }

    public function edit_category($id)
    {
        $data = Category::find($id);
        return view('admin.edit_category', compact('data'));
    }

    // public function update_category(Request $request, $id){
    //     $data= Category::find($id);
    //     $data->cat_name = $request->category;
    //     $data->cat_description = $request->category_description;

    //     $data->save();
    //     toastr()->closeButton()->success('Category Edited Successfully');
    //     return redirect('/view_category');
    // }
    public function update_category(Request $request, $id){
        try {
            $data = Category::find($id);
    
            if (!$data) {
                toastr()->closeButton()->error('Category not found');
                return redirect('/view_category');
            }
    
            $originalCatName = $data->cat_name;
            $originalCatDescription = $data->cat_description;
    
            $data->cat_name = $request->category;
            $data->cat_description = $request->category_description;
    
            if ($data->isDirty()) {  // Check if any fields were changed
                $data->save();
                toastr()->closeButton()->success('Category Edited Successfully');
            } else {
                toastr()->closeButton()->error('No changes were made');
            }
            
            return redirect('/view_category');
        } catch (\Exception $e) {
            toastr()->closeButton()->error('An error occurred: ' . $e->getMessage());
            return redirect('/view_category');
        }
    }
    
    public function add_product(){

        $category = Category::all();
        return view('admin.add_product', compact('category'));
    }

    public function upload_product(Request $request)
    {
    try {
        $data = new Product;

        $data->pro_name = $request->producto_name;
        $data->pro_description = $request->producto_description;
        $data->pro_price = $request->producto_price;
        $data->pro_stock = $request->producto_stock;
        $data->category = $request->producto_category;

        // Procesar la imagen si se ha proporcionado
        if ($request->hasFile('producto_image')) {
            $image = $request->file('producto_image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('products', $imagename); // Guardar la imagen en la carpeta 'products'
            $data->pro_image = $imagename; // Asignar el nombre de la imagen al modelo Product
        }

        // Guardar el producto en la base de datos
        $data->save();
        toastr()->closeButton()->success('Product Added Successfully');
        return redirect()->back();
    } catch (\Exception $e) {
        toastr()->closeButton()->error('There was an error adding the product: ' . $e->getMessage());
        return redirect()->back()->withInput();
    }
    }

    public function view_product(){

        $product= Product::paginate(1);
        return view('admin.view_product', compact('product'));
    }

    public function delete_product($id){
        $data = Product::find($id);

        $image_path= public_path('products/'.$data->pro_image);

        if(file_exists($image_path)){
            unlink($image_path);
        }

        $data->delete();

        toastr()->closeButton()->success('Product Deleted Successfully');
        return redirect()->bakc();
    }

    public function update_product($id){

        $data = Product::find($id);

        $category = Category::all();

        return view('admin.update_page', compact('data', 'category'));
    }

    public function edit_product(Request $request, $id) {
        try {
            $data = Product::find($id);
            $data->pro_name = $request->input('product_name');
            $data->pro_description = $request->product_description;
            $data->pro_price = $request->input('product_price');
            $data->pro_stock = $request->input('product_stock');
            $data->category = $request->category;
    
            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $image->move('products', $imagename); // Guardar la imagen en la carpeta 'products'
                $data->pro_image = $imagename;
            }
    
            $data->save();
            toastr()->closeButton()->success('Product Edited Successfully');
            return redirect('/view_product');
        } catch (\Exception $e) {
            toastr()->closeButton()->error('There was an error editing the product: ' . $e->getMessage());
            return redirect('/view_product');
        }
    }  
    
    public function product_search(Request $request){

        $search = $request->input('search');
        $product = Product::where('pro_name','LIKE','%'.$search.'%')-> orWhere('category','LIKE','%'.$search.'%')->paginate(3);

        return view('admin.view_product',compact('product'));
    }

    public function view_orders(){

        $data= Order::all();

        return view('admin.order', compact('data'));
    }

    public function on_the_way($id){

        $data =Order::find($id);

        $data->status='On the way';

        $data->save();

        return redirect('/view_orders');
    }

    public function delivered($id){

        $data =Order::find($id);

        $data->status='Delivered';

        $data->save();

        return redirect('/view_orders');
    }

    public function print_pdf($id){


        $data = Order::find($id);

        $pdf = Pdf::loadView('admin.invoice',compact('data'));
        return $pdf->download('invoice.pdf');

    }

    public function view_user()
    {
        $data = User::all();
        return view('admin.user', compact('data'));
    }

    //estos dos metodos son nuevos el add_user y el upload_user esta bien
    // Método para mostrar el formulario de creación de usuario
    public function add_user()
    {
       // Obtener todos los roles
       $roles = Role::all();

       // Pasar los roles a la vista
       return view('admin.add_user', compact('roles'));
    }

// Método para almacenar el nuevo usuario
public function upload_user(Request $request)
{
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'identification' => [
            'required',
            'digits:10',
            'regex:/^[0-9]+$/',
            function ($attribute, $value, $fail) {
                if (User::where('identification', $value)->exists()) {
                    toastr()->closeButton()->error('El número de cédula ya está en uso.');
                    return redirect()->back()->withInput();
                }
            },
        ],
        'firstname' => 'required|string|max:255',
        'secondname' => 'nullable|string|max:255',
        'firstlastname' => 'required|string|max:255',
        'secondlastname' => 'nullable|string|max:255',
        'email' => ['required', 'email', 'unique:users,email'],
        'rol_id' => 'required|exists:roles,id',
        'phone1' => ['required', 'digits:10', 'regex:/^[0-9]+$/'],
        'phone2' => ['nullable', 'digits:10', 'regex:/^[0-9]+$/'],
        'address' => 'nullable|string|max:255',
        'password' => ['required', 'string', 'min:8'], // Validación para la contraseña
    ]);

    try {
        // Crear un nuevo usuario
        $user = new User;
        $user->identification = $validatedData['identification'];
        $user->firstname = $validatedData['firstname'];
        $user->secondname = $validatedData['secondname'];
        $user->firstlastname = $validatedData['firstlastname'];
        $user->secondlastname = $validatedData['secondlastname'];
        $user->email = $validatedData['email'];
        $user->rol_id = $validatedData['rol_id'];
        $user->phone1 = $validatedData['phone1'];
        $user->phone2 = $validatedData['phone2'];
        $user->address = $validatedData['address'];
        $user->password = bcrypt($validatedData['password']); // Encriptar la contraseña

        // Guardar el usuario en la base de datos
        $user->save();
        
        // Mostrar mensaje de éxito
        toastr()->closeButton()->success('Usuario añadido exitosamente.');
        return redirect()->route('view_user'); // Redirigir a la vista de usuarios
    } catch (\Exception $e) {
        // Mostrar mensaje de error en caso de excepción
        toastr()->closeButton()->error('Hubo un error al añadir el usuario: ' . $e->getMessage());
        return redirect()->back()->withInput();
    }
}
  
    public function delete_user($id)
    {
        $data = User::find($id);
        $data->delete();
        toastr()->closeButton()->success('User Deleted Successfully');
        return redirect()->back();
    }

    public function edit_user($id)
    {
        $data = User::find($id);
        $roles = Role::all(); // Obtener todos los roles disponibles
        return view('admin.edit_user', compact('data', 'roles'));
    }

    public function update_user(Request $request, $id)
{
    try {
        $data = User::find($id);

        if (!$data) {
            toastr()->closeButton()->error('User not found');
            return redirect('/view_user');
        }

        $changes = [
            'identification' => $request->usr_identification,
            'firstname' => $request->urs_firstname,
            'secondname' => $request->urs_secondname,
            'firstlastname' => $request->urs_firstlastname,
            'secondlastname' => $request->urs_secondlastname,
            'email' => $request->correo,
            'rol_id' => $request->urs_rol,
            'phone1' => $request->urs_phone1,
            'phone2' => $request->urs_phone2,
            'address' => $request->urs_direccion,
        ];

        $originalData = $data->only(array_keys($changes));

        // Check if there are any changes
        if ($changes == $originalData) {
            toastr()->closeButton()->info('No changes detected');
            return redirect('/view_user');
        }

        // Update the user's data
        $data->update($changes);

        toastr()->closeButton()->success('User Updated Successfully');
        return redirect('/view_user');
    } catch (\Exception $e) {
        toastr()->closeButton()->error('An error occurred: ' . $e->getMessage());
        return redirect('/view_user')->with('error', 'Failed to update user');
    }
}

//Roles
    public function view_rol(){

        $data = Role::all();
        return view('admin.rol',compact('data'));
    }

    public function add_rol(Request $request)
{
    try {
        $rol = new Role;

        $rol->rol_name = $request->role_name;
        $rol->rol_description = $request->role_description;

        $rol->save();

        toastr()->closeButton()->success('Role added successfully');
        return redirect()->back();
    } catch (\Exception $e) {
        toastr()->error('Failed to add role: ');
        return redirect()->back()->withInput();
    }
}

public function delete_role($id){
    if (in_array($id, [1, 2])) {
        toastr()->closeButton()->error('This role cannot be deleted.');
        return redirect()->back();
    }

    $data = Role::find($id);
    $data->delete();

    toastr()->closeButton()->success('Role Deleted Successfully');
    return redirect()->back();
}

public function edit_role($id)
{
    // Obtener los datos del rol
    $data = Role::find($id);

    // Verificar si el rol existe
    if (!$data) {
        toastr()->closeButton()->error('Role not found');
        return redirect('/view_rol');
    }

    return view('admin.edit_rol', compact('data'));
}

public function update_role(Request $request, $id)
{
    // Validar la entrada
    $request->validate([
        'role_name' => 'required|string|max:255',
        'role_description' => 'required|string|max:255',
    ]);

    try {
        // Encontrar el rol
        $data = Role::find($id);

        // Verificar si el rol existe
        if (!$data) {
            toastr()->closeButton()->error('Role not found');
            return redirect('/view_rol');
        }

        // Actualizar los campos del rol
        $data->rol_name = $request->input('role_name');
        $data->rol_description = $request->input('role_description');
        $data->save();

        toastr()->closeButton()->success('Role Edited Successfully');
        return redirect('/view_rol');
    } catch (\Exception $e) {
        toastr()->closeButton()->error('An error occurred: ' . $e->getMessage());
        return redirect('/view_rol');
    }
}

//Permisos
public function view_permissions()
{
    // Obtener todos los permisos
    $permissions = Permission::all();

    // Pasar los permisos a la vista
    return view('admin.view_permissions', compact('permissions'));
}

// Mostrar el formulario para agregar un nuevo permiso
public function add_permission(Request $request)
{
    // Lógica para agregar un permiso
    // Validación
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
    ]);

    // Crear permiso
    $permission = new Permission();
    $permission->name = $request->name;
    $permission->description = $request->description;
    $permission->save();

    // Redirigir con mensaje de éxito
    toastr()->success('Permission added successfully');
    return redirect()->route('view_permissions');
}

// Mostrar el formulario para editar un permiso
public function edit_permission($id)
{
    // Obtener el permiso a editar
    $permission = Permission::findOrFail($id);

    // Devolver la vista con el permiso
    return view('admin.edit_permission', compact('permission'));
}

// Actualizar un permiso
public function update_permission(Request $request, $id)
{
    // Validar la entrada
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ]);

    try {
        // Encontrar el permiso
        $permission = Permission::find($id);

        // Verificar si el permiso existe
        if (!$permission) {
            toastr()->closeButton()->error('Permission not found');
            return redirect('/view_permissions');
        }

        // Actualizar los campos del permiso
        $permission->name = $request->input('name');
        $permission->description = $request->input('description');
        $permission->save();

        toastr()->closeButton()->success('Permission updated successfully');
        return redirect('/view_permissions');
    } catch (\Exception $e) {
        toastr()->closeButton()->error('An error occurred: ' . $e->getMessage());
        return redirect('/view_permissions');
    }
}

// Eliminar un permiso
public function delete_permission($id)
{
    try {
        // Encontrar el permiso
        $permission = Permission::find($id);

        // Verificar si el permiso existe
        if (!$permission) {
            toastr()->closeButton()->error('Permission not found');
            return redirect('/view_permissions');
        }

        // Eliminar el permiso
        $permission->delete();

        toastr()->closeButton()->success('Permission deleted successfully');
        return redirect('/view_permissions');
    } catch (\Exception $e) {
        toastr()->closeButton()->error('An error occurred: ' . $e->getMessage());
        return redirect('/view_permissions');
    }
}

//Añadir permisos y borrar a roles

// AdminController.php

public function manage_roles_permissions()
{
    $roles = Role::with('permissions')->where('id', '!=', 2)->get();
    $permissions = Permission::all();
    

    return view('admin.manage_roles_permissions', compact('roles', 'permissions'));
}

public function assign_permissions(Request $request, $roleId)
{
    try {
        // Validación de permisos
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($roleId);

        // Agregar permisos sin eliminar los existentes
        $role->permissions()->attach($request->input('permissions'));

        toastr()->closeButton()->success('Permisos asignados correctamente.');
        return redirect()->back();
    } catch (\Exception $e) {
        toastr()->closeButton()->error('Ocurrió un error: ' . $e->getMessage());
        return redirect()->back();
    }
}

public function remove_permission($roleId, $permissionId)
{
    try {
        $role = Role::findOrFail($roleId);
        $role->permissions()->detach($permissionId);

        toastr()->closeButton()->success('Permiso eliminado correctamente.');
        return redirect()->back();
    } catch (\Exception $e) {
        toastr()->closeButton()->error('Ocurrió un error: ' . $e->getMessage());
        return redirect()->back();
    }
}

}