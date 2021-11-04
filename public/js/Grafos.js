function Mtrizdecamino(Cnodos,vertices,isdirigido){
var matriz = CrearMatriz(Cnodos);
for(var i=0;i<vertices.length;i++){
  matriz[vertices[i][0]][vertices[i][1]]= (matriz[vertices[i][0]][vertices[i][1]])+1;
  if(!isdirigido){

    matriz[vertices[i][1]][vertices[i][0]] = (matriz[vertices[i][1]][vertices[i][0]])+1;
    }    

}
return matriz;
} 
function CrearMatriz(lado){
  var matriz = new Array(lado);
  for (var x=0;x<lado;x++){
    matriz[x] = new Array(lado);
    for (var y=0;y<lado;y++){
      matriz[x][y]= 0;
    }

  }
 return matriz;
}

console.log(Mtrizdecamino(5,[[0,2],[1,2],[0,1],[0,1],[2,1],[1,0]],true));